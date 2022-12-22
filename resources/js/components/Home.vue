<template>
    <el-container>
        <el-main v-loading="loading">
            <el-card>
                <div slot="header">
                    <span>Links</span>

                    <el-button
                        type="primary"
                        @click="generateNewLink"
                        size="small"
                        class="ml-20"
                    >
                        Generate new link
                    </el-button>
                </div>

                <el-table
                    :data="manualLinks"
                >
                    <el-table-column
                        label="Link"
                        min-width="300"
                    >
                        <template slot-scope="scope">
                            <el-link
                                :href="scope.row.linkUrl"
                                type="primary"
                            >
                                {{ scope.row.link }}
                            </el-link>
                        </template>
                    </el-table-column>

                    <el-table-column
                        prop="due_date"
                        label="Due Date"
                        min-width="300"
                    />

                    <el-table-column
                        label="Action"
                        min-width="300"
                    >
                        <template slot-scope="scope">
                            <el-button
                                v-if="scope.row.status"
                                type="danger"
                                @click="deactivateLink(scope.row.id)"
                                size="mini"
                            >
                                Deactivate
                            </el-button>
                            <span
                                v-else
                                class="badge bg-danger"
                            >
                                Deactivated
                            </span>
                        </template>
                    </el-table-column>
                </el-table>
            </el-card>

            <el-card class="mt-20">
                <div slot="header">
                    <span>Game</span>

                    <el-button
                        type="primary"
                        @click="play"
                        size="small"
                        class="ml-20"
                    >
                        I'm feeling lucky
                    </el-button>

                    <el-button
                        type="primary"
                        @click="showHistory"
                        size="small"
                        class="ml-20"
                    >
                        History
                    </el-button>
                </div>

                <span v-if="randomNumber">{{ randomNumber }}</span>

                <div v-if="score">
                    <span
                        :class="score.is_win ? 'won' : 'lose'"
                    >
                        {{ score.score }} {{ score.is_win ? 'Win' : 'Lose' }}
                    </span>
                </div>

                <el-table
                    v-if="history.length"
                    :data="history"
                >
                    <el-table-column
                        prop="score"
                        label="Score"
                        min-width="300"
                    />

                    <el-table-column
                        label="Status"
                        min-width="300"
                    >
                        <template slot-scope="scope">
                            {{ scope.row.is_win ? 'Win' : 'Lose' }}
                        </template>
                    </el-table-column>

                    <el-table-column
                        prop="created_at"
                        label="At"
                        min-width="300"
                    />
                </el-table>
            </el-card>
        </el-main>
    </el-container>
</template>

<script>
export default {
    name: "Home",
    props: {
        link: {
            type: Object,
            required: true,
        },
        user: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            loading: false,
            manualLinks: this.user.manual_links,
            score: null,
            randomNumber: null,
            historyVisible: false,
            history: [],
        }
    },
    methods: {
        generateNewLink() {
            this.loading = true;
            axios.post(`${this.link.link}/store`)
                .then(response => {
                    this.manualLinks = response.data.data;
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        deactivateLink(id) {
            this.loading = true;
            axios.post(`${this.link.link}/link/${id}/deactivate`)
                .then(response => {
                    this.manualLinks = response.data.data;
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        play() {
            this.loading = true;
            this.score = null;
            this.randomNumber = Math.floor(Math.random() * 1000) + 1;

            axios.post(`${this.link.link}/score`, { number: this.randomNumber })
                .then(response => {
                    this.score = response.data.data;
                    if (this.historyVisible) {
                        this.showHistory();
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        showHistory() {
            this.loading = true;
            this.historyVisible = true;

            axios.get(`${this.link.link}/score`)
                .then(response => {
                    this.history = response.data.data;
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    },
}
</script>

<style lang="scss" scoped>
    .el-table {
        width: 100%;
    }
    .ml-20 {
        margin-left: 20px;
    }
    .mt-20 {
        margin-top: 20px;
    }
    .won {
        color: green;
    }
    .lose {
        color: red;
    }
</style>
