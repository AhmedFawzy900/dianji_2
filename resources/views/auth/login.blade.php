<x-guest-layout>
   <section class="login-content">
      <div class="container h-100">
         <div class="row align-items-center justify-content-center h-100">
            <div class="col-md-5">
               <div class="card p-3">
                  <div class="card-body">
                     <div class="auth-logo">
                        <a href="{{route('frontend.index')}}">
                           <img src="{{ getSingleMedia(imageSession('get'), 'logo', null) }}"
                              class="img-fluid rounded-normal" alt="logo">
                        </a>
                     </div>
                     <h3 class="mb-3 font-weight-bold text-center">{{__('تسجيل الدخول')}}</h3>
                     <!-- <p class="text-center text-secondary mb-4">{{__('')}}</p> -->
                     <!-- Session Status -->
                     <x-auth-session-status class="mb-4" :status="session('status')" />

                     <!-- Validation Errors -->
                     <x-auth-validation-errors class="mb-4" :errors="$errors" />
                     <form method="POST" action="{{ route('login') }}" data-toggle="validator">
                        {{csrf_field()}}
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label class="text-secondary">{{__('الايميل')}} <span
                                       class="text-danger">*</span></label>
                                 <input id="email" name="email" value="{{request('email')}}" class="form-control"
                                    type="email" placeholder="ادخل الايميل"
                                    required autofocus>
                                 <small class="help-block with-errors text-danger"></small>
                              </div>
                           </div>
                           <div class="col-lg-12 mt-2">
                              <div class="form-group">
                                 <div class="d-flex justify-content-between align-items-center">
                                    <label class="text-secondary">كلمة المرور<span
                                          class="text-danger">*</span></label>
                                    <label><a
                                          href="{{route('auth.recover-password')}}">نسيت كلمة المرور ؟</a></label>
                                 </div>
                                 <input class="form-control" type="password" value="{{request('password')}}"
                                    placeholder="ادخل كلمة المرور"
                                    name="password" required autocomplete="current-password">
                                 <small class="help-block with-errors text-danger"></small>
                              </div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-2">{{__('تسجيل الدخول')}}</button>
                        <div class="col-lg-12 mt-3">
                           <p class="mb-0 text-center">ليس لديك حساب؟ <a
                                 href="{{route('auth.register')}}">{{__('انشاء حساب')}}</a></p>
                        </div>
                     </form>
                  </div>
               </div>
            </div>

         </div>

         <div class="mt-1">
            <h6 class="mb-3 text-capitalize text-center">{{__('حسابات للتجربه')}}</h6>
            <div class="px-5 py-3 bg-primary">
               <ul
                  class="iq-social-list-text d-flex align-items-center justify-content-center flex-wrap m-0 list-inline">
                  <li class="me-3 mx-1 pe-3">
                     <a href="{{ route('auth.login', ['email' => 'admin@admin.com', 'password' => 'admin123']) }}"
                        class="text-capitalize text-white">{{__('ادمن')}}</a>
                  </li>
                  <li class="me-3 mx-1 pe-3">
                     <a href="{{ route('auth.login', ['email' => 'demo@provider.com', 'password' => '12345678']) }}"
                        class="text-capitalize text-white">{{__('شركه')}}</a>
                  </li>
                  <li class="me-3 mx-1 pe-3">
                     <a href="{{ route('auth.login', ['email' => 'demo@handyman.com', 'password' => '12345678']) }}"
                        class="text-capitalize text-white">{{__('عامل')}}</a>
                  </li>
                  <li class="mx-1">
                     <a href="{{ route('auth.login', ['email' => 'demo@user.com', 'password' => '12345678']) }}"
                        class="text-capitalize text-white">{{__('مستخدم')}}</a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </section>
</x-guest-layout>