var bill = new Vue({
        el: "#bill",
        data() {
            return {
                form: {
                    createBill: this.$form.createForm(this)
                },
                current: ['mail'],
                cost:[],
                Ticketdata:{
                    ticket: {
                        title:"XXX",
                        user:"XXX",
                        type:"XXX",
                        bid:"XXX",
                        bill_id:"XXXXXXXXXX",
                        create_time:"XXXX-XX-XX",
                        bill_time:"XXXX-XX-XX",
                        description:"XXXXXXXXXX",
                        money_type:"XXX",
                        money:"XXXXXXX"
                    },
                    files: {
                    }

                },
                userinfo: {
                    ident: ""
                },
                spinning: {
                    middle:false,
                    right:false
                },
                loading: {
                    middle:true,
                    right:true,
                },
                loadingMore: false,
                showLoadingMore: false,
                visible: false,
                isActive: 0,
            }
        },
        //初始化
        mounted() {
            this.getUserInfo();
        },
        //方法
        methods: {
            all: function () {
                var than = this;
                this.cost = [];
                than.loading.middle = true,
                this.spinning.middle = !this.spinning.middle;
                setTimeout(function(){
                    axios.post('/member/bill/getList')
                        .then(function (response) {
                            than.cost = response.data;
                            console.log(response.data);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    than.loading.middle = false,
                        than.spinning.middle = !than.spinning.middle;
                },500);

            },
            showTicket: function (id) {
                //this.cost = this.cost.reverse();
                var than = this;
                this.isActive = id;
                this.loading.right = true;
                this.spinning.right = !this.spinning.right;
                axios.post("/member/bill/getTicket",{"id":id}).then(function (response) {
                    if (response.data.status == "1"){
                        bill.Ticketdata = response.data;
                    }
                });
                setTimeout(function(){
                    than.loading.right = false;
                    than.spinning.right = !than.spinning.right;
                },500);
            },
            showDrawer() {
                this.visible = true
            },
            onClose() {
                this.visible = false
            },
            submitCreate(e) {
                e.preventDefault();
                this.form.createBill.validateFields((err, values) => {
                    if (!err) {
                        var  than = this;
                        axios.post("/member/bill/create",values).then(function (response) {
                            if (response.data.status == "1"){
                                bill.onClose();
                                bill.$message.success(response.data.message);
                                bill.form.createBill.resetFields();
                                bill.all();
                            }else{
                                bill.$message.error("添加失败");
                            }
                        });
                        // than.loading.middle = true,
                        // than.spinning.middle = !than.spinning.middle;
                        // setTimeout(function(){
                        //     than.cost.unshift(values)
                        //     than.loading.middle = false,
                        //     than.spinning.middle = !than.spinning.middle;
                        // },500);
                    }
                });
            },
            accept(id){
                axios.post("/member/bill/accept",{"id": id}).then(function (response) {
                    if (response.data.status == 1){
                        bill.$message.success(response.data.message);
                        bill.showTicket(id);
                    }else {
                        bill.$message.error("处理失败");
                    }
                })
            },
            nopay(id){
                axios.post("/member/bill/nopay",{"id": id}).then(function (response) {
                    if (response.data.status == 1){
                        bill.$message.success(response.data.message);
                        bill.showTicket(id);
                    }else {
                        bill.$message.error("拒支失败");
                    }
                })
            },
            getUserInfo(){
                axios.post("/member/account/getUserInfo").then(function (response) {
                    bill.userinfo = response.data;
                })
            },
            normFile  (e) {
                if (Array.isArray(e)) {
                    return e;
                }
                return e && e.fileList;
            }
        },
    })
