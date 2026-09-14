@extends('admin.app')

@section('title', trans('doctors.show_doctors'))
@section('title_page', trans('doctors.show', ['name' => @$doctor->trans->where('locale', $current_lang)->first()->title]) )

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                @foreach ($languages as $key => $locale)

                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                {{ trans('lang.' .Locale::getDisplayName($locale)) }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">



                                                {{-- title ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ @$doctor->trans->where('locale',$locale)->first()->title}}" id="title{{ $key }}">
                                                    </div>
                                                    @if($errors->has( $locale . '.title'))
                                                    <span class="missiong-spam">{{ $errors->first( $locale . '.title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3 slug-section">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="{{ $locale }}[slug]" disabled value="{{ @$doctor->trans->where('locale',$locale)->first()->slug}}" id="slug{{ $key }}" class="form-control slug" required>
                                                    </div>
                                                    @if($errors->has( $locale . '.slug'))
                                                    <span class="missiong-spam">{{ $errors->first( $locale . '.slug') }}</span>
                                                    @endif

                                                    <script>
                                                        $(document).ready(function() {
                                                            $("#title" + {
                                                                {
                                                                    $key
                                                                }
                                                            }).on('keyup', function() {
                                                                var Text = $(this).val();
                                                                Text = Text.toLowerCase();
                                                                Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                                                                $("#slug" + {
                                                                    {
                                                                        $key
                                                                    }
                                                                }).val(Text);
                                                            });
                                                        });

                                                    </script>
                                                </div>

                                                {{-- description ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in') {{trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea id="description{{ $key }}" name="{{ $locale }}[description]" disabled> {{ @$doctor->trans->where('locale',$locale)->first()->description }} </textarea>
                                                        @if($errors->has( $locale . '.description'))
                                                        <span class="missiong-spam">{{ $errors->first( $locale . '.description') }}</span>
                                                        @endif
                                                    </div>

                                                    <script type="text/javascript">
                                                        $(function() {
                                                            CKEDITOR.replace('description{{$key}}');
                                                            $('.textarea').wysihtml5()
                                                        })

                                                    </script>
                                                </div>

                                                {{-- appointments ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.content_in') {{ trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea id="content{{ $key }}" name="{{ $locale }}[content]" disabled> {{ @$doctor->trans->where('locale',$locale)->first()->appointments }} </textarea>
                                                        @if($errors->has( $locale . '.content'))
                                                        <span class="missiong-spam">{{ $errors->first( $locale . '.content') }}</span>
                                                        @endif
                                                    </div>

                                                    <script type="text/javascript">
                                                        $(function() {
                                                            CKEDITOR.replace('content{{$key}}');
                                                            $('.textarea').wysihtml5()
                                                        })

                                                    </script>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach



                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $key }}" aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                                                @lang('admin.meta')
                                            </button>
                                        </h2>
                                        <div id="collapseTwo{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTwo{{ $key }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                @foreach ($languages as $key => $locale)


                                                {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[meta_title]" disabled value="{{ @$doctor->trans->where('locale',$locale)->first()->meta_title}}" id="title{{ $key }}">
                                                    </div>
                                                    @if($errors->has( $locale . '.meta_title'))
                                                    <span class="missiong-spam">{{ $errors->first( $locale . '.meta_title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_description_in') {{ trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea name="{{ $locale }}[meta_description]" class="form-control description" disabled> {{ @$doctor->trans->where('locale',$locale)->first()->meta_description }} </textarea>
                                                        @if($errors->has( $locale . '.meta_description'))
                                                        <span class="missiong-spam">{{ $errors->first( $locale . '.meta_description') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_key_in') {{ trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea name="{{ $locale }}[meta_key]" class="form-control description" disabled> {{ @$doctor->trans->where('locale',$locale)->first()->meta_key }} </textarea>
                                                        @if($errors->has( $locale . '.meta_key'))
                                                        <span class="missiong-spam">{{ $errors->first( $locale . '.meta_key') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr>

                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                {{ trans('admin.settings') }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                @if( @$doctor->image != null)
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-12">
                                                            <a href="{{ asset( $doctor->image) }}" target="_blank">
                                                                <img src="{{asset( $doctor->image)}}" alt="" style="width:100%">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                {{-- phone ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-specialty" col-form-label>
                                                            @lang('specialties.specialties')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" disabled type="text" placeholder="@lang('specialties.specialty')" name="phone" value="{{ $doctor->specialty->title }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- phone ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-phone" col-form-label>
                                                            @lang('admin.phone')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" disabled type="text" placeholder="@lang('admin.phone')" name="phone" value="{{ $doctor->phone }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- email ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-email" col-form-label>
                                                            @lang('admin.email')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" disabled type="email" placeholder="@lang('admin.email')" name="email" value="{{ $doctor->email }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- address ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-address" col-form-label>
                                                            @lang('admin.address')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" disabled type="text" placeholder="@lang('admin.address')" name="address" value="{{ $doctor->address }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- degree ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-degree" col-form-label>
                                                            @lang('admin.degree')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" disabled type="text" placeholder="@lang('admin.degree')" name="degree" value="{{ $doctor->degree  }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- facebook ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-facebook" col-form-label>
                                                            @lang('admin.facebook')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" disabled type="text" placeholder="@lang('admin.facebook')" name="facebook" value="{{ $doctor->facebook  }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- twitter ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-twitter" col-form-label>
                                                            @lang('admin.twitter')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" disabled type="text" placeholder="@lang('admin.twitter')" name="twitter" value="{{ $doctor->twitter }}">
                                                        </div>
                                                    </div>
                                                </div>


                                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-input" col-form-label> @lang('articles.sort'):</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" disabled type="number" disabled placeholder="@lang('articles.sort'):" id="example-number-input" value="{{ $doctor->sort }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12 ">
                                                    <label class="col-md-3 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                                    @if($doctor->feature == 1 )
                                                    <p class="badge  bg-success h3" style="font-size:20px">@lang("admin.yes")</p>
                                                    @else
                                                    <p class="badge  bg-danger h3" style="font-size:20px">@lang("admin.no")</p>
                                                    @endif
                                                </div>

                                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <label class="col-sm-3 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                                    @if($doctor->status == 1 )
                                                    <p class="badge  bg-success h3" style="font-size:20px">@lang("admin.active")</p>
                                                    @else
                                                    <p class="badge  bg-danger h3" style="font-size:20px">@lang("admin.dis_active")</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3 text-end">
                                <div>
                                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div> <!-- end row-->

</div> <!-- container-fluid -->

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
@endsection
