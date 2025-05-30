@extends('site.myaccount.layouts.master')
@section('page_title', __('Settings'))
@section('content')
    @php
        $parsedUA = (new App\Services\UserAgentParserService())->parse(request()->header('user-agent'));
        extract($parsedUA);
    @endphp
    <main class="md:w-3/5 lg:w-3/4 w-full main-content flex flex-col flex-1" id="customer_settings">
        <p class="text-2xl text-black font-medium">{{ __("Settings") }}</p>
        <div class="flex">
        </div>
        <section class="items-center xl:w-3/5 mt-3">
            <a href="javaScript:void(0)" class="open-pass-modal">
                <div class="flex items-center justify-between border border-gray-300 rounded-lg">
                    <div class="w-full cursor-pointer lg:p-6 p-4 flex justify-start items-center gap-4">
                        <svg class="w-14 h-14 p-4 rounded bg-gray-300" width="22" height="22" viewBox="0 0 22 22"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.5 7.33398C5.5 4.29642 7.96244 1.83398 11 1.83398C13.2568 1.83398 15.1941 3.19307 16.042 5.13364C16.2446 5.59756 16.0329 6.13795 15.569 6.34064C15.1051 6.54333 14.5647 6.33157 14.362 5.86766C13.7953 4.57074 12.5021 3.66732 11 3.66732C8.97496 3.66732 7.33333 5.30894 7.33333 7.33398V8.25214C7.55123 8.25064 7.78286 8.25065 8.02881 8.25065H13.9712C14.7091 8.25064 15.3181 8.25063 15.8142 8.29116C16.3294 8.33326 16.8031 8.42361 17.248 8.65029C17.9379 9.00183 18.4988 9.56276 18.8504 10.2527C19.077 10.6976 19.1674 11.1712 19.2095 11.6865C19.25 12.1826 19.25 12.7916 19.25 13.5294V14.8885C19.25 15.6264 19.25 16.2354 19.2095 16.7315C19.1674 17.2467 19.077 17.7204 18.8504 18.1653C18.4988 18.8552 17.9379 19.4161 17.248 19.7677C16.8031 19.9944 16.3294 20.0847 15.8142 20.1268C15.3181 20.1673 14.7091 20.1673 13.9712 20.1673H8.02879C7.29091 20.1673 6.68192 20.1673 6.18583 20.1268C5.67057 20.0847 5.19693 19.9944 4.75204 19.7677C4.06211 19.4161 3.50118 18.8552 3.14964 18.1653C2.92296 17.7204 2.83261 17.2467 2.79051 16.7315C2.74998 16.2354 2.74999 15.6264 2.75 14.8885V13.5295C2.74999 12.7916 2.74998 12.1826 2.79051 11.6865C2.83261 11.1712 2.92296 10.6976 3.14964 10.2527C3.50118 9.56276 4.06211 9.00183 4.75204 8.65029C4.9923 8.52788 5.24094 8.44522 5.5 8.38845V7.33398ZM6.33512 10.1184C5.93324 10.1512 5.72772 10.2108 5.58435 10.2838C5.23939 10.4596 4.95892 10.74 4.78316 11.085C4.71011 11.2284 4.65059 11.4339 4.61776 11.8358C4.58405 12.2484 4.58333 12.7821 4.58333 13.5673V14.8507C4.58333 15.6358 4.58405 16.1696 4.61776 16.5822C4.65059 16.9841 4.71011 17.1896 4.78316 17.333C4.95892 17.6779 5.23939 17.9584 5.58435 18.1342C5.72772 18.2072 5.93324 18.2667 6.33512 18.2996C6.7477 18.3333 7.28147 18.334 8.06667 18.334H13.9333C14.7185 18.334 15.2523 18.3333 15.6649 18.2996C16.0668 18.2667 16.2723 18.2072 16.4157 18.1342C16.7606 17.9584 17.0411 17.6779 17.2168 17.333C17.2899 17.1896 17.3494 16.9841 17.3822 16.5822C17.416 16.1696 17.4167 15.6358 17.4167 14.8507V13.5673C17.4167 12.7821 17.416 12.2484 17.3822 11.8358C17.3494 11.4339 17.2899 11.2284 17.2168 11.085C17.0411 10.74 16.7606 10.4596 16.4157 10.2838C16.2723 10.2108 16.0668 10.1512 15.6649 10.1184C15.2523 10.0847 14.7185 10.084 13.9333 10.084H8.06667C7.28147 10.084 6.7477 10.0847 6.33512 10.1184ZM11 12.3757C11.5063 12.3757 11.9167 12.7861 11.9167 13.2923V15.1257C11.9167 15.6319 11.5063 16.0423 11 16.0423C10.4937 16.0423 10.0833 15.6319 10.0833 15.1257V13.2923C10.0833 12.7861 10.4937 12.3757 11 12.3757Z"
                                fill="#2C2C2C" />
                        </svg>
                        <div>
                            <p class="font-medium text-black leading-6">{{ __("Change Password") }}</p>
                            <p class="text-sm font-medium text-gray-500 leading-6">{{ __("Set a unique password to protect your account.") }}</p>
                        </div>
                    </div>
                </div>
            </a>
            @if (auth()->user()->role()?->slug != 'super-admin')
            <a href="javaScript:void(0)" class="open-delete-modal"
                data-url="{{ route('site.user.delete') }}"
                data-method="post">
                <div class="flex items-center justify-between border border-gray-300 rounded-lg mt-3">
                    <div class="w-full cursor-pointer lg:p-6 p-4 flex justify-start items-center gap-4">
                        <svg class="w-14 h-14 p-4 rounded bg-yellow-400" width="22" height="22" viewBox="0 0 22 22"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M7.33203 2.75065C7.33203 2.24439 7.74244 1.83398 8.2487 1.83398H13.7487C14.255 1.83398 14.6654 2.24439 14.6654 2.75065C14.6654 3.25691 14.255 3.66732 13.7487 3.66732H8.2487C7.74244 3.66732 7.33203 3.25691 7.33203 2.75065ZM4.57492 4.58398H2.7487C2.24244 4.58398 1.83203 4.99439 1.83203 5.50065C1.83203 6.00691 2.24244 6.41732 2.7487 6.41732H3.72444L4.31266 15.2406C4.35882 15.9331 4.39701 16.5062 4.4655 16.9726C4.5368 17.4583 4.64991 17.9021 4.88553 18.3157C5.25233 18.9595 5.80559 19.4771 6.47241 19.8003C6.90076 20.0079 7.35109 20.0912 7.84041 20.13C8.31037 20.1673 8.88471 20.1673 9.57873 20.1673H12.4187C13.1127 20.1673 13.687 20.1673 14.157 20.13C14.6463 20.0912 15.0966 20.0079 15.525 19.8003C16.1918 19.4771 16.7451 18.9595 17.1119 18.3157C17.3475 17.9021 17.4606 17.4583 17.5319 16.9726C17.6004 16.5062 17.6386 15.9331 17.6847 15.2405L18.273 6.41732H19.2487C19.755 6.41732 20.1654 6.00691 20.1654 5.50065C20.1654 4.99439 19.755 4.58398 19.2487 4.58398H17.4225C17.4171 4.58394 17.4118 4.58394 17.4064 4.58398H4.59096C4.58562 4.58394 4.58028 4.58394 4.57492 4.58398ZM16.4356 6.41732H5.56184L6.13951 15.0824C6.18871 15.8203 6.22272 16.3204 6.27938 16.7063C6.33442 17.0811 6.40166 17.2733 6.4785 17.4082C6.6619 17.7301 6.93853 17.9889 7.27194 18.1505C7.41164 18.2182 7.60782 18.2725 7.98548 18.3024C8.37431 18.3333 8.87556 18.334 9.61513 18.334H12.3823C13.1218 18.334 13.6231 18.3333 14.0119 18.3024C14.3896 18.2725 14.5858 18.2182 14.7255 18.1505C15.0589 17.9889 15.3355 17.7301 15.5189 17.4082C15.5957 17.2733 15.663 17.0811 15.718 16.7063C15.7747 16.3204 15.8087 15.8203 15.8579 15.0824L16.4356 6.41732ZM9.16536 8.70898C9.67163 8.70898 10.082 9.11939 10.082 9.62565V14.209C10.082 14.7152 9.67163 15.1257 9.16536 15.1257C8.6591 15.1257 8.2487 14.7152 8.2487 14.209V9.62565C8.2487 9.11939 8.6591 8.70898 9.16536 8.70898ZM12.832 8.70898C13.3383 8.70898 13.7487 9.11939 13.7487 9.62565V14.209C13.7487 14.7152 13.3383 15.1257 12.832 15.1257C12.3258 15.1257 11.9154 14.7152 11.9154 14.209V9.62565C11.9154 9.11939 12.3258 8.70898 12.832 8.70898Z"
                                fill="#2C2C2C" />
                        </svg>
                        <div>
                            <p class="font-medium text-black leading-6">{{ __("Delete Account") }}</p>
                            <p class="text-sm font-medium text-gray-500 leading-6">{{ __("You won’t be able to retrieve your account anymore.") }}</p>
                        </div>
                    </div>
                </div>
            </a>
            @endif
            <p class="font-medium text-sm text-gray-400 leading-5 mt-8">{{ __("Log Activities") }}</p>
            <a href="{{ route('site.userActivity') }}"
                class="flex justify-between items-center border border-gray-300 rounded-lg mt-3 lg:p-6 p-4">
                <div class="flex items-center justify-between">
                    <div class="w-full cursor-pointer flex justify-start items-center gap-4">
                        <svg class="w-14 h-14 p-4 rounded bg-gray-300" width="22" height="22" viewBox="0 0 22 22"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_20638_2846)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.0013 0.916016C11.5076 0.916016 11.918 1.32642 11.918 1.83268V2.7997C15.742 3.22242 18.7782 6.2587 19.201 10.0827H20.168C20.6742 10.0827 21.0846 10.4931 21.0846 10.9993C21.0846 11.5056 20.6742 11.916 20.168 11.916H19.201C18.7782 15.74 15.742 18.7763 11.918 19.199V20.166C11.918 20.6723 11.5076 21.0827 11.0013 21.0827C10.495 21.0827 10.0846 20.6723 10.0846 20.166V19.199C6.26065 18.7763 3.22437 15.74 2.80165 11.916H1.83464C1.32837 11.916 0.917969 11.5056 0.917969 10.9993C0.917969 10.4931 1.32837 10.0827 1.83464 10.0827H2.80165C3.22437 6.2587 6.26065 3.22242 10.0846 2.7997V1.83268C10.0846 1.32642 10.495 0.916016 11.0013 0.916016ZM11.0013 4.58268C7.45747 4.58268 4.58464 7.45552 4.58464 10.9993C4.58464 14.5432 7.45747 17.416 11.0013 17.416C14.5451 17.416 17.418 14.5432 17.418 10.9993C17.418 7.45552 14.5451 4.58268 11.0013 4.58268ZM11.0013 9.16602C9.98878 9.16602 9.16797 9.98683 9.16797 10.9993C9.16797 12.0119 9.98878 12.8327 11.0013 12.8327C12.0138 12.8327 12.8346 12.0119 12.8346 10.9993C12.8346 9.98683 12.0138 9.16602 11.0013 9.16602ZM7.33464 10.9993C7.33464 8.9743 8.97626 7.33268 11.0013 7.33268C13.0263 7.33268 14.668 8.9743 14.668 10.9993C14.668 13.0244 13.0263 14.666 11.0013 14.666C8.97626 14.666 7.33464 13.0244 7.33464 10.9993Z"
                                    fill="#2C2C2C" />
                            </g>
                            <defs>
                                <clipPath id="clip0_20638_2846">
                                    <rect width="22" height="22" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <div>
                            <p class="font-medium text-black leading-6">{{ __("Current Device") }}</p>
                            <p class="text-sm font-medium text-gray-500 leading-6">{{ $browser . ' ' . $version }} • {{ $platform }}
                            </p>
                        </div>
                    </div>
                </div>
                <svg class="neg-transition-scale" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5.5312 3.52925C5.79155 3.2689 6.21366 3.2689 6.47401 3.52925L10.474 7.52925C10.7344 7.7896 10.7344 8.21171 10.474 8.47206L6.47401 12.4721C6.21366 12.7324 5.79155 12.7324 5.5312 12.4721C5.27085 12.2117 5.27085 11.7896 5.5312 11.5292L9.0598 8.00065L5.5312 4.47206C5.27085 4.21171 5.27085 3.7896 5.5312 3.52925Z"
                        fill="#898989" />
                </svg>
            </a>
        </section>
    </main>

    {{-- change password --}}
    <div class="fixed hidden items-center inset-0 bg-black bg-opacity-50 overflow-y-auto z-99999 pass-modal">
        <div
            class="relative md:mt-40 xl:mt-20 sm:mx-auto mx-4 md:px-8 px-3 py-6 w-max rounded-xl bg-white modal-h modal-box-shadow transition-all ease-in-out">
            <svg class="lg:block hidden absolute top-3 ltr:right-3 rtl:left-3 cursor-pointer text-black pass-close-btn" width="13"
                height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M0.455612 0.455612C1.06309 -0.151871 2.04802 -0.151871 2.6555 0.455612L11.9888 9.78895C12.5963 10.3964 12.5963 11.3814 11.9888 11.9888C11.3814 12.5963 10.3964 12.5963 9.78895 11.9888L0.455612 2.6555C-0.151871 2.04802 -0.151871 1.06309 0.455612 0.455612Z"
                    fill="#898989" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.9897 0.455612C11.3822 -0.151871 10.3973 -0.151871 9.78981 0.455612L0.45648 9.78895C-0.151003 10.3964 -0.151003 11.3814 0.45648 11.9888C1.06396 12.5963 2.04889 12.5963 2.65637 11.9888L11.9897 2.6555C12.5972 2.04802 12.5972 1.06309 11.9897 0.455612Z"
                    fill="#898989" />
            </svg>
            <form action="{{ route('site.password.update') }}" method="POST">
                @csrf
                <p class="text-xl text-black font-medium">{{ __("Change Password") }}</p>
                <p class="text-base text-gray-400 font-medium mb-8">
                    {{ __("Your new password should be different from the old password.") }}</p>
                <label class="text-black font-normal text-sm">{{ __("Old Password") }}</label>
                <div class="relative password-container mb-6">
                    <input
                        class="password password-field border border-gray-300 rounded w-full h-12 font-medium text-sm text-black form-control mt-1.5 p-3"
                        type="password" name="old_password" required
                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                </div>
                <label class="text-black font-normal text-sm">{{ __("New Password") }}</label>
                <div class="relative password-container mb-6">
                    <div class="flex flex-col gap-2">
                        <input
                            class="password password-field border border-gray-300 rounded w-full h-12 font-medium text-sm text-black form-control mt-1.5 p-3"
                            name="new_password"
                            type="password" required
                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                    </div>
                    <a href="javascript: void(0)">
                        <svg class="absolute ltr:right-3 rtl:left-3 top-5 pass-eye" width="20" height="20" viewBox="0 0 20 20"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="M9.99967 3.75C5.83301 3.75 2.27467 6.34167 0.833008 10C2.27467 13.6583 5.83301 16.25 9.99967 16.25C14.1663 16.25 17.7247 13.6583 19.1663 10C17.7247 6.34167 14.1663 3.75 9.99967 3.75ZM9.99967 14.1667C7.69967 14.1667 5.83301 12.3 5.83301 10C5.83301 7.7 7.69967 5.83333 9.99967 5.83333C12.2997 5.83333 14.1663 7.7 14.1663 10C14.1663 12.3 12.2997 14.1667 9.99967 14.1667ZM9.99967 7.5C8.61634 7.5 7.49967 8.61667 7.49967 10C7.49967 11.3833 8.61634 12.5 9.99967 12.5C11.383 12.5 12.4997 11.3833 12.4997 10C12.4997 8.61667 11.383 7.5 9.99967 7.5Z"
                                    fill="#898989" />
                            </g>
                            <defs>
                                <clipPath>
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <svg class="password-show absolute ltr:right-3 rtl:left-3 top-5" width="20" height="20"
                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="M9.99967 3.75C5.83301 3.75 2.27467 6.34167 0.833008 10C2.27467 13.6583 5.83301 16.25 9.99967 16.25C14.1663 16.25 17.7247 13.6583 19.1663 10C17.7247 6.34167 14.1663 3.75 9.99967 3.75ZM9.99967 14.1667C7.69967 14.1667 5.83301 12.3 5.83301 10C5.83301 7.7 7.69967 5.83333 9.99967 5.83333C12.2997 5.83333 14.1663 7.7 14.1663 10C14.1663 12.3 12.2997 14.1667 9.99967 14.1667ZM9.99967 7.5C8.61634 7.5 7.49967 8.61667 7.49967 10C7.49967 11.3833 8.61634 12.5 9.99967 12.5C11.383 12.5 12.4997 11.3833 12.4997 10C12.4997 8.61667 11.383 7.5 9.99967 7.5Z"
                                    fill="#898989" />
                            </g>
                            <defs>
                                <clipPath>
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <svg class="password-hide absolute ltr:right-3 rtl:left-3 top-5" width="20" height="20"
                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.2706 2.47187C16.0262 2.2275 15.6312 2.2275 15.3868 2.47187L13.6593 4.19937C12.5662 3.75937 11.3456 3.47562 9.99932 3.47562C3.99994 3.47562 0.252442 9.29625 0.0961922 9.54437C0.00369221 9.69125 -0.0200578 9.86187 0.0161922 10.0187C-0.0138078 10.1675 0.00556721 10.3269 0.0911922 10.4669C0.178067 10.6094 1.41744 12.585 3.61744 14.2425L2.16557 15.6937C1.92119 15.9381 1.92119 16.3331 2.16557 16.5775C2.28744 16.6994 2.44744 16.7606 2.60744 16.7606C2.76744 16.7606 2.92744 16.6994 3.04932 16.5775L16.2706 3.35562C16.5143 3.11187 16.5143 2.71625 16.2706 2.47187ZM6.39932 9.96312C6.39932 7.97812 8.01432 6.36312 9.99932 6.36312C10.4443 6.36312 10.8693 6.44687 11.2624 6.59562L10.2243 7.63375C10.1493 7.62562 10.0762 7.61312 9.99932 7.61312C8.70369 7.61312 7.64932 8.6675 7.64932 9.96312C7.64932 10.04 7.66244 10.1131 7.66994 10.1881L6.63182 11.2262C6.48307 10.8337 6.39932 10.4081 6.39932 9.96312ZM19.9024 10.4556C19.7462 10.7031 15.9987 16.5244 9.99932 16.5244C8.43307 16.5244 7.03307 16.1437 5.81119 15.5762L8.26932 13.1175C8.78307 13.4006 9.37307 13.5625 9.99994 13.5625C11.9849 13.5625 13.5999 11.9475 13.5999 9.9625C13.5999 9.33562 13.4381 8.74625 13.1549 8.23187L15.9487 5.43812C18.4199 7.14937 19.8162 9.38125 19.9081 9.5325C19.9937 9.6725 20.0131 9.83187 19.9831 9.98062C20.0187 10.1387 19.9956 10.3087 19.9024 10.4556ZM9.21807 12.1694L12.2056 9.1825C12.2931 9.42812 12.3493 9.68875 12.3493 9.96375C12.3493 11.2594 11.2949 12.3137 9.99932 12.3137C9.72432 12.3131 9.46369 12.2569 9.21807 12.1694Z"
                                fill="#898989" />
                        </svg>
                    </a>
                </div>
                <label fclass="text-black font-normal text-sm">{{ __("Confirm New Password") }}</label>
                <div class="relative password-container mb-6">
                    <input
                        class="password password-field border border-gray-300 rounded w-full h-12 font-medium text-sm text-black form-control mt-1.5 p-3"
                        name="confirm_password"
                        type="password" required
                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                </div>
                <button class="w-full rounded py-3 cursor-pointer font-semibold text-white bg-black">
                    {{ __("Update Password") }}
                </button>
            </form>
        </div>
    </div>
    @include('site.myaccount.layouts.delete')
@endsection
