<x-guest-layout>
<section class="flex flex-col items-center h-screen md:flex-row ">
            <div class="hidden w-full h-screen bg-white lg:block md:w-1/3 lg:w-2/3">
                 <img src="https://www.usep.edu.ph/cdm/wp-content/uploads/sites/57/2019/02/aaahm2.jpg"
                    alt="" class="object-cover w-full h-full">
                    
            </div>
            <div class="flex items-center justify-center w-full h-screen px-6 bg-white md:max-w-md lg:max-w-full md:mx-auto md:w-1/2 xl:w-1/3 lg:px-16 xl:px-12"> 
                <div class="w-full h-200">
                        <a href="{{url('/')}}">
                            <div class="flex mb-5">
                                <svg class="p-0.5 h-6 w-6 rounded-full z-20 bg-white dark:bg-gray-800 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                <span class=" text-black-800 dark:text-gray-400  font-light">Back to login</span>
                            </div>
                        </a>
                    <a class="flex items-center w-32 mb-4 font-medium text-gray-900 title-font md:mb-0">
                    <!-- <div class="w-2 h-2 p-2 mr-2 rounded-full bg-gradient-to-tr from-cyan-400 to-lightBlue-500">
                    </div> -->
                    <img src="https://www.usep.edu.ph/wp-content/themes/usep-website/images/usep-logo2.png" alt=""class="w-20 h-20 m-1">
                    <p class="m-1 text-xl font-bold tracking-tighter text-black uppercase transition duration-500 ease-in-out transform hover:text-lightBlue-500 dark:text-blueGray-400">
                        {{config('app.name')}}
                    </p>
                    </a>


                    <h1 class="mt-10 mb-5 text-2x1 font-semibold text-black tracking-ringtighter sm:text-2xl title-font"> {{ __('Reset your password.') }}</h1>
                           
                        <!-- Validation Errors -->
                     <x-auth-validation-errors class="mb-4" :errors="$errors" />


                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div>
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)"  />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />

                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autofocus />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password"
                                                name="password_confirmation" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button>
                                {{ __('Reset Password') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
</section>
</x-guest-layout>


