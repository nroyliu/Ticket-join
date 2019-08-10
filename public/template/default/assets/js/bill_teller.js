var bill = new Vue({
        el: "#bill",
        data() {
            return {
                form: {
                    createBill: this.$form.createForm(this)
                },
                current: ['mail'],
                cost:[],
                showbill:{
                    title:"活动费用",
                    user:"laupx",
                    type:"非业务",
                    bid:"0000000000",
                    bill_id:"XXXXXXXXXX",
                    create_time:"2019-7-31",
                    bill_time:"2019-7-31",
                    description:"描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述",
                    money_type:"收入",
                    money:"200000"
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
            console.log(moment().toDate())
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
            showTicket: function (index) {
                //this.cost = this.cost.reverse();
                var than = this;
                this.isActive = index;
                this.loading.right = true;
                this.spinning.right = !this.spinning.right;
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
                        console.log('Received values of form: ', values);
                        values.create_time = "2019-7-31"
                        values.bid = "20190731001"
                        values.status = "1"
                        console.log(this);
                        than.loading.middle = true,
                        than.spinning.middle = !than.spinning.middle;
                        setTimeout(function(){
                            than.cost.unshift(values)
                            than.loading.middle = false,
                            than.spinning.middle = !than.spinning.middle;
                        },500);
                    }
                });
            },
            normFile  (e) {
                console.log('Upload event:', e);
                if (e.file.status == "done"){
                    console.log("id:"+e.file.response.fileid);
                }
                if (Array.isArray(e)) {
                    return e;
                }
                return e && e.fileList;
            },
        },
    })
