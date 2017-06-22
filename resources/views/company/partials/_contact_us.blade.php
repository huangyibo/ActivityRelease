<div id="company-about-speech" class="company-business-content">
    <div class="category-header">
        <h4 class="font3"><i class="fa fa-folder-open-o"></i> お問い合わせ</h4>
    </div>

    <div class="content-body" style="padding: 0px 10px;">
        <main>
            <div class="col-md-offset-1" style="padding: 0px 20px;line-height: 35px;font-size: 17px;">
                必要事項をご記入いただき、[送信]ボタンをクリックしてください。
                <br>
                お問い合わせの内容を確認後、ご返答いたします。
                <br>
                お急ぎの場合はお電話<span style="color: #f46660;font-size: 20px;">（03-6907-1339）</span>でご連絡ください。
                <br>
            </div>
            <hr  style="margin-bottom: 40px">

            <div id="contact-us-alert-danger" class="alert alert-danger alert-dismissible hidden" style="height: 40px;padding-left: 20px" role="alert">
            </div>

            <div id="contact-us-alert-success" class="alert alert-success alert-dismissible hidden" style="height: 40px;padding-left: 20px" role="alert">
            </div>

            {{--<form id="contact-us-form" name="contactUsForm" action="{{url('/company/contact-us')}}" method="post"--}}
                  {{--class="form-horizontal" novalidate="">--}}
            <form class="form-horizontal">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="" style="width: 15%;" class="col-md-offset-1 col-sm-4 col-md-4 col-lg-4 control-label">貴社名</label>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <input class="form-control" name="company_name" type="text" id="company_name" placeholder="貴社名">
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3 help-block">
                        例：株式会社YAKUMO
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-offset-1 col-sm-4 col-md-4 col-lg-4 control-label" style="width: 15%;">お名前</label>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <input class="form-control" name="name" type="text" id="name" placeholder="お名前" required>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3 help-block">
                        <span style="color: red;">*</span> 必須項目です。
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-offset-1 col-sm-4 col-md-4 col-lg-4 control-label" style="width: 15%;">メールアドレス</label>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <input class="form-control" id="email" name="email" type="email" placeholder="メールアドレス" required>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3 help-block">
                        <span style="color: red;">*</span> 必須項目です。
                    </div>
                </div>

                <div class="form-group ">
                    <label for="" class="col-md-offset-1 col-sm-4 col-md-4 col-lg-4 control-label" style="width: 15%;">電話番号</label>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <input class="form-control" id="phone" name="phone" type="text">
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3 help-block">

                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-offset-1 col-sm-4 col-md-4 col-lg-4 control-label" style="width: 15%;">お問い合わせ区分</label>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <select class="form-control " id="contact_type" name="contact_type">
                            <option value="お選びください" selected>お選びください
                            </option>
                            <option value="サービス内容について">
                                サービス内容について
                            </option>
                            <option value="弊社について">弊社について
                            </option>
                            <option value="その他お問い合わせ">その他お問い合わせ
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3 help-block"></div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-offset-1 col-sm-4 col-md-4 col-lg-4 control-label" style="width: 15%;">お問い合わせ内容</label>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                                <textarea class="form-control" rows="5" name="contact_content" cols="50"
                                          id="contact_content">
                                </textarea>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3 help-block">
                        <span style="color: red;">*</span> 必須項目です
                    </div>
                </div>
                {{--id="btn_submit_contact_info"--}}
                <div class="form-group">
                    <label class="col-md-offset-1 col-sm-4 col-md-4 col-lg-4 control-label" style="width: 15%;"></label>
                    <div class="col-md-4">
                        <button class="btn btn-lg btn-primary " id="btn_submit_contact_info" data-loading-text="Sending..." style="font-size: 14px" type="button"
                                title="送信">
                            送 &nbsp;&nbsp; 信
                        </button>
                    </div>
                </div>
            </form>

        </main>

    </div>
</div>