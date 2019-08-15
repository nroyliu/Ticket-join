var app = new Vue({
    el: "#app",
    data() {
        return {
            form:{
                changepwd: this.$form.createForm(this),
            },
            changepwd:{
                visible: false,
            },
            page:"/member/bill/user",
            nav:{
                current: ['bill']
            },
            confirmDirty: false,
        }
    },
    mounted() {
        this.getUserInfo();
    },
    methods: {
        logout(){
            axios.post("/member/user/logout").then(function (response) {
                window.location.href = "/";
            })
        },
        showModal () {
            this.changepwd.visible = true;
        },
        handleCancel  () {
            this.changepwd.visible = false;
        },
        handleCreate  () {
            this.form.changepwd.validateFields((err, values) => {
                if (!err) {
                    axios.post("/member/account/changePassword",values).then(function (response) {
                        if (response.data.status == 1){
                            app.$message.success(response.data.message);
                        } else {
                            app.$message.error(response.data.message);
                        }
                    })
                    app.form.changepwd.resetFields();
                    app.changepwd.visible = false;
                }
            });
        },
        compareToFirstPassword  (rule, value, callback) {
            const form = this.form.changepwd;
            if (value && value !== form.getFieldValue('password')) {
                callback('您输入的两个密码不一致!');
            } else {
                callback();
            }
        },
        validateToNextPassword  (rule, value, callback) {
            const form = this.form.changepwd;
            if (value && this.confirmDirty) {
                form.validateFields(['confirm'], { force: true });
            }
            callback();
        },
        handleConfirmBlur  (e) {
            const value = e.target.value;
            this.confirmDirty = this.confirmDirty || !!value;
        },
        getUserInfo(){
            axios.post("/member/account/getUserInfo").then(function (response) {
                app.userinfo = response.data;
                app.$notification.open({
                    message: '欢迎回来！',
                    description: app.userinfo.username,
                });
            })
        },
    },
})