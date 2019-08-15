var app = new Vue({
    el: "#app",
    data() {
        return {
            login_status: 0,
            form: null,
            email_valid: null,
            valid_text: null
        }
    },
    //初始化
    mounted() {
        this.form = this.$form.createForm(this);
    },
    //方法
    methods: {
        handleSubmit(e) {
            e.preventDefault();
            //错误验证
            this.form.validateFields((err, values) => {
                console.log(values);
                if (!err) { //无填写错误
                    this.email_valid = 'validating';
                    var formData = new FormData();
                    formData.append('username', values['username']);
                    formData.append('password', values['password']);
                    console.log(formData);
                    axios.post('/member/user/login', {
                        'username': values['username'],
                        'password': values['password']
                    })
                        .then(function (response) {
                            console.log(response.data.status);
                            if (response.data.status == 1) {
                                app.email_valid = 'success';
                                app.valid_text = null;
                                window.location.href = '/member/account';
                            } else {
                                console.log("登录失败");
                                app.email_valid = 'error';
                                app.valid_text = response.data.messages;
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                    this.email_valid = 'warning';
                    this.valid_text = 'Incorrect email or password';
                }
            });
        },
    },
})