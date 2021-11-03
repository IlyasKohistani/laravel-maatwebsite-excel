@extends('main')

@section('title', 'Imports')
@section('style')
<link rel="stylesheet" href="{{ asset('css/drag-drop.css') }}">
@endsection


@section('content')

    <main class="pt-5 d-flex flex-column align-items-center">
        <div class="drop-zone w-100 mt-3">
            <span class="drop-zone__prompt">Drop file here or click to upload</span>
            <input type="file"  accept=".xls,.xlsx" class="drop-zone__input">
          </div>

          <div id="excel_data" class="mt-4 table-responsive-xl">
              
          </div>
    </main>


@endsection

@section('script')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script src="{{ asset('js/drag-drop.js') }}"></script>
<script src="{{ asset('js/imports.js') }}"></script>
@endsection
