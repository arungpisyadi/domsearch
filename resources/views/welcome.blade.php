<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('vendor/autocomplete/auto-complete.css') }}">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search Domain Based on Keywords') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form id="search" class="flex justify-center pt-8 sm:pt-0">
                    <input type="text" name="query" id="query" value="" class="form-input px-4 py-3 rounded-sm rounded-r-none border-2 border-blue-600 border-r-0 w-4/6 sm:w-3/6">
                    <input type="submit" name="submit" id="submit" value="Find!" class="form-input px-4 py-3 rounded-full rounded-l-none border-blue-600 border-2 border-l-0 w-2/6 sm:w-1/6 cursor-pointer bg-blue-500 text-gray-100">
                </form>

                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 w-full relative h-auto" style="min-height: 8rem;">
                        <table class="table-fixed">
                            <thead>
                                <tr>
                                    <th class="w-1/4 px-4 py-2 text-light-blue-600">Domain</th>
                                    <th class="w-1/4 px-4 py-2 text-light-blue-600">Zone (extension)</th>
                                    <th class="w-1/4 px-4 py-2 text-light-blue-600">Status</th>
                                    <th class="w-1/4 px-4 py-2 text-light-blue-600">Summary</th>
                                </tr>
                            </thead>
                            <tbody id="response" class="min-h-full"></tbody>
                        </table>
                        <div id="loader" class="absolute top-0 left-0 w-full h-full text-center py-12 bg-white bg-opacity-70 invisible">
                            <span class="text-xl text-blue-500 font-bold">Loading ...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('vendor/autocomplete/auto-complete.min.js') }}"></script>
    <script>
        var xhr;
        var autocomplete = new autoComplete({
            selector: 'input[name="query"]',
            source: function(term, response){
                try { xhr.abort(); } catch(e){}
                xhr = $.getJSON('{{ route('callbacks.suggest') }}', { query: term }, function(data){ response(data); });
            }
        });
        $('document').ready(function(){
            $('body').on('submit', 'form#search', function(e){
                e.preventDefault();
                $('#loader').removeClass('invisible');
                var data = $('form#search').serializeArray();
                console.log(data);
                $.ajax({
                    type: "get",
                    url: "{{ route('callbacks.index') }}",
                    data: data,
                    dataType: 'html',
                    success: function (response) {
                        $('#response').html(response);
                        $('#loader').addClass('invisible');
                    }
                });
            });
        });
    </script>
</x-guest-layout>