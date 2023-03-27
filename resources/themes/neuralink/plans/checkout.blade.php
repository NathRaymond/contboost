<x-front-layout>
    <div class="container">
        <div class="hero-title center mb-4 mt-4">
            <h1>@lang('document.checkoutTitle')</h1>
            <p class="mb-0">@lang('document.checkoutDescriptionFst')</p>
        </div>
        <x-form method="post" :route="route('payments.process')">
            <input type="hidden" name="plan_id" value="{{ $plan_id }}" required>
            <input type="hidden" name="type" value="{{ $type }}" required>
            <input type="hidden" name="price" value="{{ $price }}" required>

            <div class="row match-height mb-4">
                <div class="col-md-12 mb-3">
                    <div class="item bg-white p-4 box-shadow">
                        <div class="row">
                            <div class="mb-3">
                                <h6 class="m-0">@lang('document.paymentMethods')</h6>
                            </div>
                            <hr class="mb-4">
                            @foreach ($gateways as $key => $gateway)
                                <div class="col-md-6">
                                    <div class="custom-radio-checkbox">
                                        <label class="radio-checkbox-wrapper">
                                            <input type="radio" class="radio-checkbox-input gateway-checkbox"
                                                name="gateway" value="{{ $key }}" checked />
                                            <span class="radio-checkbox-tile w-100">
                                                {!! $gateway->getIcon() !!}
                                                <span>{{ $gateway->getName() }}</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4 order-md-2 mb-3">
                    <div class="item bg-white p-4 box-shadow">
                        <div class="row mb-4" id="gatewayview-div"></div>
                        <h6 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">@lang('document.orderSummary')</span>
                        </h6>
                        <hr class="mb-4">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">{{ $plan->name }}</h6>
                                    <small class="text-muted">{{ $plan->description }}</small>
                                </div>
                                <span class="text-muted">
                                    <x-money amount="{{ $price }}" currency="{{ setting('currency', 'usd') }}"
                                        convert />
                                    / {{ $type }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-bold">@lang('common.total')</span>
                                <strong>
                                    <x-money amount="{{ $price }}" currency="{{ setting('currency', 'usd') }}"
                                        convert />
                                </strong>
                            </li>
                        </ul>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-block w-100 mb-4" type="submit">@lang('document.completePurchase')</button>
                    </div>
                </div>
                <div class="col-md-8 order-md-1 mb-3">
                    <div class="bg-white item p-4 box-shadow">
                        <div class="row">
                            <h6 class="mb-3">@lang('document.billingAddress')</h6>
                            <hr class="mb-4">
                            <div class="col-md-6 mb-3">
                                <x-input-label>{{ __('document.firstName') }}</x-input-label>
                                <input type="text" class="form-control" id="firstName" placeholder=""
                                    value="{{ Auth::user()->name }}" required name="first_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-input-label>{{ __('document.lastName') }}</x-input-label>
                                <input type="text" class="form-control" id="lastName" placeholder="" value=""
                                    required name="last_name">
                            </div>
                            <div class="col-md-12 mb-3">
                                <x-input-label>{{ __('document.email') }}</x-input-label>
                                <input type="email" class="form-control" id="email" placeholder="you@example.com"
                                    name="email" required value="{{ Auth::user()->email }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <x-input-label>{{ __('document.addressLane1') }}</x-input-label>
                                <input type="text" class="form-control" id="address" placeholder="1234 Main St"
                                    required name="address_lane_1">
                            </div>
                            <div class="col-md-12 mb-3">
                                <x-input-label>{{ __('document.addressLane2') }} <span
                                        class="text-muted">(Optional)</span>
                                </x-input-label>
                                <input type="text" class="form-control" id="address2"
                                    placeholder="Apartment or suite" name="address_lane_2">
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-input-label>{{ __('document.countryCode') }}</x-input-label>
                                <input type="text" class="form-control" id="country_code" placeholder="US"
                                    name="country_code">
                            </div>
                            <div class="col-md-6 mb-3">
                                <x-input-label>{{ __('document.postalCode') }}</x-input-label>
                                <input type="text" class="form-control" id="zip" placeholder="" required
                                    name="postal_code">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-form>
    </div>
    @push('page_scripts')
        <script>
            const APP = function() {
                const getView = function() {
                        var inputs = document.querySelectorAll('.gateway-checkbox');
                        var gatewayValue;
                        for (var i = 0; i < inputs.length; i++) {
                            if (inputs[i].checked) {
                                gatewayValue = inputs[i].value;
                            }
                        }
                        FrontApp.showLoader()
                        axios.post(
                                '{{ route('payments.gateway-view') }}', {
                                    gateway: gatewayValue
                                })
                            .then((res) => {
                                FrontApp.hideLoader()
                                console.log(res, res.data, res.data.view);
                                document.getElementById('gatewayview-div').innerHTML = res.data.view;
                            })
                            .catch((err) => {
                                FrontApp.hideLoader()
                                resultError(element, cursor)
                            })
                    },
                    attachEvents = function() {
                        document.querySelectorAll('.gateway-checkbox').forEach(button => {
                            button.onclick = function() {
                                getView()
                            }
                        });
                    };
                return {
                    init: function() {
                        attachEvents();
                        getView();
                    }
                }
            }()
            document.addEventListener("DOMContentLoaded", function(event) {
                APP.init();
            });
        </script>
    @endpush
</x-front-layout>
