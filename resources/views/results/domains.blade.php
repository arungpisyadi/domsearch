@forelse ($data as $item)
    <tr>
        <td class="w-1/4 border border-light-blue-500 px-4 py-2 text-light-blue-600 font-medium">{{ $item['domain'] }}</td>
        <td class="w-1/4 border border-light-blue-500 px-4 py-2 text-light-blue-600 font-medium">{{ $item['zone'] }}</td>
        <td class="w-1/4 border border-light-blue-500 px-4 py-2 text-light-blue-600 font-medium">{{ $item['status'] }}</td>
        <td class="w-1/4 border border-light-blue-500 px-4 py-2 text-light-blue-600 font-medium">{{ $item['summary'] }}</td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="w-full border border-light-blue-500 px-4 py-2 text-light-blue-600 font-medium">No record found!</td>
    </tr>
@endforelse