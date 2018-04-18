<template>


    <div>

        <el-row :gutter="24">
            <el-col :span="20" :offset="2">
                <div class="grid-content bg-purple">

                    <el-card class="box-card">

                        <div slot="header" class="clearfix">


                            <div style="text-align: center;">

                                <h3>Please support me.</h3>
                                <p>Support Time Hunter (A completely free time management software.) </p>
                                <div>
                                    <p>Paypal</p>
                                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                        <input type="hidden" name="cmd" value="_s-xclick">
                                        <input type="hidden" name="hosted_button_id" value="86DJ8L37TK65Q">
                                        <input type="image"
                                               src="https://www.paypalobjects.com/en_AU/i/btn/btn_donateCC_LG.gif"
                                               border="0" name="submit"
                                               alt="PayPal – The safer, easier way to pay online!">
                                        <img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif"
                                             width="1" height="1">
                                    </form>

                                </div>

                                <div>
                                    <p>Wechat</p>
                                    <img :src="'/img/wechat.jpg'"  height="250" width="200">
                                </div>
                            </div>

                            <!--<i class="fas fa-clock fa-8x" style="color: red;"></i>-->
                        </div>
                        <div style="font-size:16px;">

                            <p style="color: red;"><i class="fas fa-heart fa-2x" style="color:red;"></i>
                                &nbsp;&nbsp;Thank you for supporting Time Hunter, every $2 will help our servers run for
                                another 1 hour.</p>
                            <p>The application is built by my spare time. I do really enjoy my time on implementing this
                                website. I wish you had a good journey on Time Hunter.</p>

                            <p>However, The server is currently host on Amazon Web
                                Service - Free tier. The free server has a lot of limitations and random disconnections.
                                My apologies
                                for the inconvenience this may have caused.</p>

                            <p> In order to make website stable and free for the long term, I need to seek for
                                helps.</P>

                            <ul>- If you are interested in software development, please contact me to help the software
                                growth up.
                            </ul>
                            <ul>- Please donate to support our server expenses. Then I can add more functionalities to
                                it.
                            </ul>

                            <p>My sincerest appreciation goes to every one of you.</p>

                            <p style="text-align: right;">by Ryan Deng, 31st March, 2018</p>
                        </div>

                    </el-card>
                </div>
            </el-col>
        </el-row>


    </div>
</template>

<script>

    export default {
        data() {
            return {};
        },
        mounted() {

        },
        methods: {}
    }
</script>


<style>
    h3 {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

</style>