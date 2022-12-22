<template>
    <el-main v-loading="loading">
        <el-form
            v-if="!url"
            :model="user"
            :rules="rules"
            ref="form"
            label-width="80px"
        >
            <el-form-item
                label="Name"
                prop="name"
            >
                <el-input
                    v-model="user.name"
                    placeholder="Enter user name"
                />
            </el-form-item>

            <el-form-item
                label="Mobile"
                prop="mobile"
            >
                <el-input
                    v-model="user.mobile"
                    placeholder="Enter mobile number"
                />
            </el-form-item>

            <el-form-item>
                <el-button
                    type="primary"
                    @click="submit"
                >
                    Register
                </el-button>
            </el-form-item>
        </el-form>

        <el-card
            v-else
        >
            <div slot="header">
                <span>Your new Link</span>
            </div>

            <a :href="url">{{ url }}</a>
        </el-card>
    </el-main>
</template>

<script>
    export default {
        name: 'register-form',
        data() {
            return {
                loading: false,
                user: {
                    name: null,
                    mobile: null,
                },
                rules: {
                    name: [
                        { required: true, message: 'Please enter name', trigger: 'blur' },
                    ],
                    mobile: [
                        { required: true, message: 'Please enter mobile number', trigger: 'blur' },
                    ],
                },
                url: null,
                errorMessages: []
            }
        },
        methods: {
            submit() {
                this.$refs.form.validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        axios.post('register', this.user)
                            .then(response => {
                                this.errorMessages = []
                                this.url = response.data.data['url']
                            })
                            .catch(error => {
                                this.errorMessages = error.response.data.errors;
                            })
                            .finally(() => {
                                this.loading = false;
                            });
                    }
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .el-form {
        width: 50%;
        margin: auto;
    }
</style>
