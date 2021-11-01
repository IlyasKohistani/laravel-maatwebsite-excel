@extends('main')

@section('title', 'Shop Packages')
@section('style')

@endsection


@section('content')

    <main class="d-flex align-items-center">
        <div class="container">
            <div id="wizard">
                <h3></h3>
                <section>
                    <h5 class="bd-wizard-step-title">Step 1</h5>
                    <h2 class="section-heading">Select Shop </h2>
                    <p>All existing shops are listed down here orderd by date. Please select a shop in order to continue
                        adding a product and it is package to it.</p>
                    <div class="form-group purpose-radios-wrapper">
                        <select name="shops_selection" id="shops_selection" class="form-control form-control-lg w-75">
                            @foreach ($shops as $shop)
                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </section>
                <h3></h3>
                <section>
                    <h5 class="bd-wizard-step-title">Step 2</h5>
                    <h2 class="section-heading">Select Product </h2>
                    <p>All existing products are listed down here orderd by date. Please select a product in order to
                        continue adding a product and it is package to selected shop.</p>
                    <div class="form-group purpose-radios-wrapper">
                        <select name="product_selection" id="product_selection" class="form-control form-control-lg w-75">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </section>
                <h3></h3>
                <section>
                    <h5 class="bd-wizard-step-title">Step 2</h5>
                    <h2 class="section-heading">Select Package </h2>
                    <p>All available packages are listed down here based on the products quantity. Please select a package
                        in order to add it to the selected shop.</p>
                    <div class="form-group purpose-radios-wrapper">
                        <div id="package_alert_box">

                        </div>
                        <select name="package_selection" id="package_selection" class="form-control form-control-lg">
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="table table-bordered" id="table_sizes">
                        @if (count($packages) > 0)
                            <thead>
                                @foreach ($packages[0]->sizes as $size)
                                    <th>{{ $size->name }}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                @foreach ($packages[0]->sizes as $size)
                                    <th>{{ $size->pivot->quantity }}</th>
                                @endforeach
                            </tbody>

                        @endif
                    </table>
                </section>
            </div>
            <div class="wizard vertical">
            <table class="table table-bordered mt-5" id="table_shop_details" @if (count($shop_packages) == 0) style="visibility: hidden" @endif>
                @if (count($shops) > 0)
                <thead>
                    <tr>
                        <th colspan="3"  id="table_shop_details_name" class="text-center">{{ $shops[0]->name }}  <a href="{{ route('export.shop_details', ['shop_id' => $shops[0]->id]) }}" class="float-right text-success"  data-toggle="tooltip"  data-placement="top" title="Download Detailed Excel File"><i class="bi bi-file-earmark-excel-fill"></i></a></th>
                    </tr>
                    <tr>
                        <th>Products</th>
                        <th>Packages</th>
                        <th>Package Quantity</th>
                    </tr>
                </thead>
                <tbody id="table_shop_details_body">
                    @foreach ($shop_packages as $shop_package)
                        <tr>
                            <td>{{ $shop_package->product_name }}</td>
                            <td>{{ $shop_package->package_name }}</td>
                            <td>{{ $shop_package->total_packages }}</td>
                        </tr>
                    @endforeach
                </tbody>
                @endif
            </table>
        </div>
        </div>
    </main>
    </section>


@endsection

@section('script')
    <script>
         config.packages = {!! json_encode($packages->toArray()) !!};
        @if (count($packages) == 0)
            config.func.packageBox.show('No package is available for the selected product.');
        @endif
    </script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
