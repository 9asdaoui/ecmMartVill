@extends('site.myaccount.layouts.master')
@section('page_title', __('Notifications'))
@section('content')
    @php
        $notificationsQuery = App\Models\DatabaseNotification::query()
            ->where('notifiable_type', App\Models\User::class)
            ->where('notifiable_id', auth()->user()->id)
            ->orderBy('read_at')
            ->orderByDesc('created_at');

        $notifications = app(Illuminate\Pipeline\Pipeline::class)
            ->send($notificationsQuery)
            ->through([
                App\Filters\NotificationDateFilter::class,
                App\Filters\NotificationTypeFilter::class,
            ])
            ->thenReturn()
            ->paginate(preference('row_per_page'));
    @endphp
    <main class="md:w-3/5 lg:w-3/4 w-full main-content flex flex-col flex-1" id="user_notification_container">
        <section>
            <div class="flex justify-between lg:items-center sm:gap-7 gap-3 flex-wrap mb-2.5">
                <p class="text-2xl text-black font-medium">{{ __("Notification") }}</p>
                <div class="flex gap-2 day-sorting">
                    @php
                        $filterDay = [
                            'all_time' => __('All Time'),
                            'today' => __('Today'),
                            'last_week' => __('Last 7 Days'),
                            'last_month' => __('Last 30 Days'),
                            'last_year' => __('Last 12 Months'),
                        ];
                    @endphp
                    <select data-type="filter_day"
                        class="customer-filter border border-gray-400 rounded flex justify-between items-center p-2 font-medium text-sm text-black form-control genderSelect days-conntainer">
                        @foreach ($filterDay as $key => $value)
                            <option @selected(request('filter_day') == $key) value="{{ $key }}" class="font-medium text-sm text-black">{{ $value }}</option>
                        @endforeach
                    </select>
                    @php
                        $filterType = [
                            'all_notification' => __('All Notification'),
                            'read' => __('Read'),
                            'unread' => __('Unread'),
                        ];
                    @endphp
                    <select data-type="filter_type"
                        class="customer-filter border border-gray-400 rounded flex justify-between items-center p-2 font-medium text-sm text-black form-control genderSelect days-conntainer">
                        @foreach ($filterType as $key => $value)
                            <option @selected(request('filter_type') == $key) value="{{ $key }}" class="font-medium text-sm text-black">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <ul class="border border-b-0 border-gray-300 rounded">
                @forelse ($notifications as $notification)
                    <li
                        class="transition delay-150 bg-white p-4 border-b border-gray-300 flex rounded-t justify-start items-start gap-4 w-full">
                        <img class="w-10 h-10 rounded-sm border border-gray-100"
                            src="{{ asset($notification->type::$image) }}" alt="your image" />
                        <div class="flex justify-between items-center gap-3 w-full">
                            <div class="w-full">
                                <p class="font-medium text-base leading-5 text-black">{{ $notification->data['label'] }}</p>
                                <p class="font-normal text-sm text-gray-400">{{ $notification->data['message'] }}</p>
                                <p class="font-normal text-sm text-black">{{ timeToGo($notification->created_at, false, 'ago') }}</p>
                            </div>
                            <div class="flex justify-end items-center gap-3">
                                <a href="javascript:void(0)" data-id="{{ $notification->id }}" class="action-icon marked-action">
                                    <img src="{{ asset('public/frontend/svg/' . ($notification->read_at ? 'icon-eye' : 'icon-eye-off') . '.svg') }}" alt="read svg">   
                                </a>
                                <a href="javascript:void(0)" data-url="{{ route('notifications.destroy', $notification->id) }}" data-method="delete" class="open-delete-modal">
                                    <svg class="open-modal cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="16" height="17"
                                        viewBox="0 0 16 17" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.02924 12.0576C5.55357 12.0576 5.16797 11.672 5.16797 11.1963L5.16797 8.61252C5.16797 8.13685 5.55357 7.75124 6.02924 7.75124C6.50491 7.75124 6.89052 8.13685 6.89052 8.61252L6.89052 11.1963C6.89052 11.672 6.50491 12.0576 6.02924 12.0576Z"
                                            fill="#898989"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.47456 12.0576C8.99889 12.0576 8.61328 11.672 8.61328 11.1963L8.61328 8.61252C8.61328 8.13685 8.99889 7.75124 9.47456 7.75124C9.95022 7.75124 10.3358 8.13685 10.3358 8.61252L10.3358 11.1963C10.3358 11.672 9.95023 12.0576 9.47456 12.0576Z"
                                            fill="#898989"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0.883875 5.18226C0.67977 5.16833 0.413088 5.16786 0 5.16786V3.44531C0.00921245 3.44531 0.0183945 3.44531 0.0275462 3.44531C0.0460398 3.44531 0.0644092 3.44531 0.082654 3.44531H15.4203C15.4385 3.44531 15.4569 3.44531 15.4754 3.44531L15.5029 3.44531V5.16786C15.0899 5.16786 14.8232 5.16833 14.6191 5.18226C14.4227 5.19565 14.3479 5.21858 14.3121 5.23342C14.101 5.32084 13.9334 5.48851 13.846 5.69954C13.8311 5.73538 13.8082 5.81017 13.7948 6.00654C13.7809 6.21064 13.7804 6.47732 13.7804 6.89041L13.7804 12.1147C13.7804 12.8783 13.7805 13.5361 13.7097 14.0629C13.6337 14.6275 13.4626 15.1687 13.0236 15.6077C12.5847 16.0466 12.0435 16.2178 11.4789 16.2937C10.9521 16.3645 10.2942 16.3645 9.53072 16.3644H5.97222C5.20871 16.3645 4.55086 16.3645 4.02406 16.2937C3.45948 16.2178 2.91829 16.0466 2.47933 15.6077C2.04037 15.1687 1.8692 14.6275 1.7933 14.0629C1.72247 13.5361 1.7225 12.8783 1.72255 12.1148L1.72255 6.89041C1.72255 6.47732 1.72208 6.21064 1.70816 6.00654C1.69476 5.81017 1.67183 5.73538 1.65699 5.69954C1.56957 5.48851 1.40191 5.32084 1.19087 5.23342C1.15503 5.21858 1.08024 5.19565 0.883875 5.18226ZM12.2067 5.16786H3.29627C3.37705 5.40696 3.41026 5.64815 3.42671 5.88928C3.44512 6.15908 3.44511 6.48506 3.4451 6.86286L3.4451 12.0581C3.4451 12.8944 3.44693 13.4351 3.50048 13.8334C3.55071 14.207 3.6318 14.3241 3.69736 14.3896C3.76292 14.4552 3.88001 14.5363 4.25358 14.5865C4.65193 14.6401 5.19256 14.6419 6.02892 14.6419H9.47402C10.3104 14.6419 10.851 14.6401 11.2494 14.5865C11.6229 14.5363 11.74 14.4552 11.8056 14.3896C11.8711 14.3241 11.9522 14.207 12.0025 13.8334C12.056 13.4351 12.0578 12.8944 12.0578 12.0581V6.86286C12.0578 6.48506 12.0578 6.15908 12.0762 5.88928C12.0927 5.64815 12.1259 5.40696 12.2067 5.16786Z"
                                            fill="#898989"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8.96309 0.104413C8.59794 0.0343653 8.17358 0 7.75221 0C7.33084 5.1336e-08 6.90648 0.0343654 6.54133 0.104413C6.35878 0.139431 6.18006 0.185421 6.01815 0.246001C5.87108 0.301027 5.6705 0.39238 5.5008 0.550715C5.153 0.875213 5.13412 1.42022 5.45862 1.76801C5.76482 2.0962 6.26738 2.13152 6.61529 1.8618C6.61728 1.86102 6.61944 1.8602 6.62178 1.85932C6.66773 1.84213 6.74756 1.81881 6.86585 1.79612C7.10237 1.75074 7.4152 1.72255 7.75221 1.72255C8.08922 1.72255 8.40205 1.75074 8.63857 1.79612C8.75686 1.81881 8.83669 1.84213 8.88264 1.85932C8.88498 1.8602 8.88714 1.86102 8.88913 1.8618C9.23704 2.13152 9.7396 2.0962 10.0458 1.76801C10.3703 1.42021 10.3514 0.875212 10.0036 0.550714C9.83392 0.392379 9.63334 0.301026 9.48627 0.246001C9.32436 0.185421 9.14564 0.13943 8.96309 0.104413Z"
                                            fill="#898989"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </li>
                @empty
                    <li class="w-full text-center border-b">
                        <span class="font-medium text-lg text-neutral-500 text-center flex justify-center flex-col items-center gap-4 py-10">
                        <svg class="w-16 h-16" xmlns="http://www.w3.org/2000/svg" width="106"
                            height="106" viewBox="0 0 106 106" fill="none">
                            <path
                                d="M6.31466 0.35157C4.96895 0.848442 4.03731 1.51094 3.292 2.5461C2.33966 3.8711 2.07052 5.11329 2.07052 8.23946C2.07052 10.7031 2.02911 11.0758 1.65645 11.5934C1.40802 11.9246 0.97325 12.732 0.662703 13.3945L0.103719 14.5953L0.0416094 49.6871C0.000203108 80.866 0.0209062 85.0273 0.31075 87.0355C0.97325 91.5281 2.83653 96.0621 5.46583 99.4988C6.19044 100.451 6.21114 100.513 6.21114 102.397C6.21114 104.55 6.43888 105.275 7.267 105.71C7.99161 106.082 8.5713 106.082 9.29591 105.71C10.124 105.275 10.3518 104.55 10.3518 102.397C10.3518 100.513 10.3725 100.451 11.0971 99.4988C13.7057 96.0828 15.569 91.5695 16.2315 87.1184C16.5213 85.2137 16.5627 81.1559 16.5627 54.8836V24.8434H17.8049C19.2541 24.8434 20.1029 25.1953 20.4549 25.982C20.6412 26.3754 20.7033 29.191 20.7033 36.4578C20.7033 47.2441 20.7033 47.2648 21.842 47.7824C22.9393 48.2793 24.2022 47.8652 24.6162 46.8508C24.8026 46.416 24.844 43.4555 24.8026 35.816C24.7404 25.6922 24.7197 25.3402 24.3057 24.4086C23.2084 22.0484 21.3244 20.8891 18.4053 20.7441L16.6041 20.6613L16.5213 17.618C16.4592 14.8645 16.3971 14.4918 15.9002 13.3945C15.5897 12.732 15.1549 11.9453 14.9272 11.6348C14.5959 11.1379 14.5131 10.6203 14.451 7.8668C14.3682 4.30586 14.1404 3.49844 12.8568 2.00782C11.3869 0.330864 8.44708 -0.414444 6.31466 0.35157ZM9.29591 4.43008C10.0619 4.84415 10.3518 5.56876 10.3518 7.10078V8.38438H8.28145H6.21114V7.03868C6.23184 5.56876 6.52169 4.84415 7.267 4.43008C7.9088 4.07813 8.592 4.07813 9.29591 4.43008ZM10.5588 13.1254C10.9936 13.3945 11.5525 13.9949 11.8217 14.4297C12.2772 15.1336 12.3186 15.5063 12.3807 17.9492L12.4635 20.7027H8.30216H4.14083V18.3633C4.14083 17.1004 4.24434 15.6926 4.36856 15.2578C4.6377 14.3055 5.942 12.9184 6.87364 12.6492C7.97091 12.318 9.66856 12.525 10.5588 13.1254ZM12.4221 52.9996V81.1559H8.28145H4.14083V52.9996V24.8434H8.28145H12.4221V52.9996ZM12.1529 86.4766C11.8838 89.0645 10.0412 93.9711 8.69552 95.648L8.28145 96.1656L7.86739 95.648C6.52169 93.9711 4.67911 89.0645 4.40997 86.4766L4.28575 85.2965H8.28145H12.2772L12.1529 86.4766Z"
                                fill="#B0B0B0"></path>
                            <path
                                d="M36.9139 15.1956C33.1667 16.1065 29.9991 19.3776 29.2124 23.1456C29.0467 23.9116 28.9846 33.8491 28.9846 56.8295V89.437H25.6721C22.0698 89.437 21.4694 89.5819 20.9932 90.4928C20.3307 91.7971 20.8897 95.1096 22.2768 97.9252C23.0842 99.5608 23.5604 100.203 25.0303 101.673C26.521 103.163 27.1421 103.619 28.7776 104.405C32.235 106.103 30.6616 106.02 59.7288 105.958L85.4006 105.896L86.5807 105.42C89.2307 104.343 91.1768 102.583 92.419 100.078C93.6198 97.6768 93.5784 99.0639 93.5784 65.9803V35.6088H98.9612C104.903 35.6088 105.317 35.526 105.773 34.4081C105.959 33.9733 106 32.0893 105.959 27.5139L105.897 21.2202L105.234 19.8331C104.323 17.9077 103.164 16.7069 101.28 15.7753L99.7065 15.0092L68.8588 14.9678C44.6569 14.9471 37.7628 14.9885 36.9139 15.1956ZM89.9967 20.1229L89.5413 21.2202L89.4378 59.1069L89.3342 96.9936L88.7545 98.1737C87.9678 99.7678 86.4358 101.134 84.9245 101.569C81.9846 102.439 78.8585 100.969 77.5542 98.153C77.2022 97.3456 77.1194 96.7038 77.0573 94.1987C77.0366 92.5424 76.8917 90.9276 76.7674 90.617C76.2913 89.3749 77.3264 89.437 54.2424 89.437H33.1253V56.9745C33.1253 21.3444 33.0632 23.3733 34.3674 21.5721C35.0507 20.6198 36.21 19.771 37.4108 19.3362C38.0526 19.1085 42.8971 19.0671 64.3249 19.0463H90.4729L89.9967 20.1229ZM99.9963 19.7503C100.431 20.0194 100.99 20.6198 101.259 21.0546C101.735 21.8206 101.756 22.0069 101.818 26.6444L101.88 31.4682H97.7397H93.5784V27.0584C93.5784 24.6155 93.6819 22.3174 93.8061 21.8827C94.0753 20.9303 95.3795 19.5432 96.3112 19.2741C97.4085 18.9428 99.1061 19.1499 99.9963 19.7503ZM72.9167 95.6893C73.0409 97.9873 73.4963 99.6643 74.428 101.072L74.9456 101.859H54.4909C32.2143 101.859 32.9596 101.9 30.4339 100.679C28.1979 99.6022 25.7342 96.5381 25.1753 94.1366L25.051 93.5776H48.9217H72.8131L72.9167 95.6893Z"
                                fill="#B0B0B0"></path>
                            <path
                                d="M51.7788 27.6589C48.5905 28.5078 45.8991 31.3441 45.1538 34.5945C44.8226 35.9816 44.8847 38.7144 45.2573 39.9773C46.3546 43.6625 48.3007 45.9191 56.3128 52.7925C60.5777 56.457 61.0124 56.6847 62.1511 56.0843C63.062 55.6082 71.2191 48.4035 73.0823 46.4367C75.132 44.2836 76.0843 42.9171 76.9745 40.7433C77.4507 39.6046 77.5128 39.1492 77.5128 37.1617C77.5128 35.2777 77.43 34.6566 77.0159 33.6421C76.0429 31.0957 74.5523 29.398 72.3577 28.28C68.8382 26.5203 64.9667 27.2035 62.1511 30.0812L61.2609 30.9921L60.1636 29.9156C57.907 27.6589 54.8429 26.8308 51.7788 27.6589ZM55.6089 31.7789C57.1409 32.4207 58.5073 33.9941 59.1284 35.8574C59.5011 36.996 60.3292 37.6793 61.323 37.6793C62.0683 37.6793 62.9999 36.789 63.4347 35.6296C64.2214 33.5593 65.6499 32.0894 67.2855 31.6546C70.6808 30.7437 73.7862 33.8285 73.4343 37.7414C73.1859 40.5156 71.1984 43 64.946 48.3621L61.2402 51.5296L57.9277 48.6933C52.255 43.8695 50.2882 41.7371 49.4394 39.5011C49.0253 38.3832 48.9425 36.3543 49.2738 35.1535C50.0191 32.5242 53.2488 30.7851 55.6089 31.7789Z"
                                fill="#B0B0B0"></path>
                            <path
                                d="M42.4623 64.8836C40.6611 65.8773 41.4272 68.7344 43.4768 68.7344C44.5326 68.7344 45.5471 67.7199 45.5471 66.6848C45.5471 65.132 43.8287 64.1176 42.4623 64.8836Z"
                                fill="#B0B0B0"></path>
                            <path
                                d="M50.7435 64.8837C49.3564 65.6497 49.3978 67.8442 50.8263 68.486C51.5923 68.838 79.2517 68.838 80.0177 68.486C80.6181 68.2169 81.1564 67.3474 81.1564 66.6642C81.1564 65.981 80.6181 65.1114 80.0177 64.8423C79.1896 64.4696 51.4267 64.511 50.7435 64.8837Z"
                                fill="#B0B0B0"></path>
                            <path
                                d="M42.4623 77.3055C40.6611 78.2992 41.4272 81.1562 43.4768 81.1562C44.5326 81.1562 45.5471 80.1418 45.5471 79.1066C45.5471 77.5539 43.8287 76.5394 42.4623 77.3055Z"
                                fill="#B0B0B0"></path>
                            <path
                                d="M50.7435 77.3056C49.3564 78.0716 49.3978 80.2661 50.8263 80.9079C51.5923 81.2599 79.2517 81.2599 80.0177 80.9079C80.6181 80.6388 81.1564 79.7692 81.1564 79.086C81.1564 78.4028 80.6181 77.5333 80.0177 77.2642C79.1896 76.8915 51.4267 76.9329 50.7435 77.3056Z"
                                fill="#B0B0B0"></path>
                        </svg>
                        {{ __("No notification found") }}
                    </span></li>
                @endforelse
            </ul>
            @if ($notifications->count())
                <div class="flex lg:justify-between justify-center mt-30p">
                    <div class="lg:block hidden">
                        <a class="roboto-medium text-left font-medium text-base mt-30p text-gray-10">{{ __("Total Records: :x", ['x' => $notifications->total()]) }}</a>
                    </div>
                    {{ $notifications->onEachSide(1)->links('pagination::tailwind') }}
                </div>
            @endif
        </section>
    </main>
    @include('site.myaccount.layouts.delete')
@endsection
@section('js')
    <script>
        const markReadUrl = SITE_URL + '/myaccount/notifications/mark-as-read/'
        const markUnreadUrl = SITE_URL + '/myaccount/notifications/mark-as-unread/'
    </script>
@endsection
