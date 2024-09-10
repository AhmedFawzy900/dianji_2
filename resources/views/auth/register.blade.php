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
                     <h3 class="mb-3 font-weight-bold text-center">{{__('انشاء حساب')}}</h3>
                     <!-- Session Status -->
                     <x-auth-session-status class="mb-4" :status="session('status')" />

                     <!-- Validation Errors -->
                     <x-auth-validation-errors class="mb-4" :errors="$errors" />
                     <form method="POST" action="{{ route('register') }}" data-toggle="validator">
                        {{csrf_field()}}
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label for="username" class="text-secondary">اسم المستخدم <span
                                       class="text-danger">*</span></label>
                                 <input class="form-control" id="username" name="username" value="{{old('username')}}"
                                    required placeholder="أدخل اسم المستخدم">
                                 <small class="help-block with-errors text-danger"></small>
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label for="first_name" class="text-secondary">الاسم الأول <span
                                       class="text-danger">*</span></label>
                                 <input class="form-control" id="first_name" name="first_name"
                                    value="{{old('first_name')}}" required placeholder="أدخل الاسم الأول">
                                 <small class="help-block with-errors text-danger"></small>
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label for="last_name" class="text-secondary">الاسم الأخير <span
                                       class="text-danger">*</span></label>
                                 <input class="form-control" id="last_name" name="last_name"
                                    value="{{old('last_name')}}" required placeholder="أدخل الاسم الأخير">
                                 <small class="help-block with-errors text-danger"></small>
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label for="email" class="text-secondary">البريد الإلكتروني <span
                                       class="text-danger">*</span></label>
                                 <input class="form-control" type="email" id="email" name="email"
                                    value="{{old('email')}}" required placeholder="أدخل البريد الإلكتروني"
                                    pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}">
                                 <small class="help-block with-errors text-danger"></small>
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label for="password" class="text-secondary">كلمة المرور <span
                                       class="text-danger">*</span></label>
                                 <input class="form-control" type="password" id="password" name="password" required
                                    autocomplete="new-password" placeholder="أدخل كلمة المرور">
                                 <small class="help-block with-errors text-danger"></small>
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label for="password_confirmation" class="text-secondary">تأكيد كلمة المرور <span
                                       class="text-danger">*</span></label>
                                 <input class="form-control" onkeyup="checkPasswordMatch()" type="password"
                                    id="password_confirmation" name="password_confirmation" required
                                    autocomplete="new-password" placeholder="أدخل تأكيد كلمة المرور">
                                 <small class="help-block with-errors text-danger" id="confirm_passsword"></small>
                              </div>
                           </div>
                           <div class="col-lg-12 mt-2">
                              <div class="form-check mb-3 d-flex align-items-center">
                                 <input type="checkbox" class="form-check-input mt-0 " id="customCheck1" required>
                                 <label class="form-check-label pr-2 mr-1" for="customCheck1">
                                    أوافق على <a href="{{ url('/') }}/#/term-conditions">الشروط والأحكام</a> و <a
                                       href="{{ url('/') }}/#/privacy-policy">سياسة الخصوصية</a>
                                    <small class="help-block with-errors text-danger"></small>
                                 </label>
                              </div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-2" id="submit-btn">إنشاء حساب</button>
                        <div class="col-lg-12 mt-3">
                           <p class="mb-0 text-center">لديك حساب بالفعل؟ <a href="{{route('auth.login')}}">تسجيل
                                 الدخول</a></p>
                        </div>
                     </form>

                  </div>
               </div>
            </div>
         </div>
      </div>

      <script>
         function checkPasswordMatch() {

            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("password_confirmation").value;
            var errorElement = document.getElementById("confirm_passsword");
            var submitBtn = document.getElementById("submit-btn");

            if (password !== confirmPassword) {

               errorElement.innerHTML = "{{ __('auth.password_mismatch_error') }}";
               submitBtn.disabled = true;
            } else {
               errorElement.innerHTML = "";
               submitBtn.disabled = false;
            }
         }
      </script>
   </section>
</x-guest-layout>