<quick-person-search inline-template url="{{route('status.index')}}">
    <div class="modal fade" id="quick-person-search">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">جستجوی زائر</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['@submit.prevent' => 'submit']) !!}
                    <div class="text-center">
                        <input type="text" class="form-control text-center clean clean-large clean-number" dir="ltr" placeholder="کد تردد یا کد ملی" data-minlen="1" data-maxlen="20" v-focus v-input-number v-model="code" @keyup.esc="code = ''" ref="code" :disabled="disable">
                    </div>
                    <br>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-md" :disabled="disable">
                            <span v-if="loading"><i class="fa fa-refresh fa-spin"></i></span>
                            <span v-if="!loading">نمایش مشخصات و وضعیت زائر</span>
                        </button>
                    </div>

                    <div class="callout callout-danger" v-if="error" v-cloak>
                        <h4>@{{error}}</h4>
                    </div>

                    <div class="row" ref="result" style="display: none"></div>
                    <div class="clearfix"></div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</quick-person-search>