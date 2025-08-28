<div>
    @if($exam->examAttempts->isNotEmpty())
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Nama Murid</th>
                <th scope="col" class="px-6 py-3">NISN</th>
                <th scope="col" class="px-6 py-3">Skor Akhir</th>
                <th scope="col" class="px-6 py-3">Waktu Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exam->examAttempts as $attempt)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $attempt->student->user->name }}
                </th>
                <td class="px-6 py-4">
                    {{ $attempt->student->nisn }}
                </td>
                <td class="px-6 py-4 font-bold">
                    {{ round($attempt->score) }}%
                </td>
                <td class="px-6 py-4">
                    {{ \Carbon\Carbon::parse($attempt->finished_at)->format('d M Y, H:i') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center text-gray-500 py-4">
        <p>Belum ada murid yang mengerjakan ujian ini.</p>
    </div>
    @endif
</div>