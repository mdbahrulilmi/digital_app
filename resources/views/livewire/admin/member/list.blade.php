<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Data Member
            </h2>

            <p class="text-sm text-slate-500">
                Kelola seluruh member yang telah terdaftar.
            </p>
        </div>

        <div class="relative">

            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari nama / whatsapp..."
                class="w-full md:w-72 rounded-xl border border-slate-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500">

        </div>

    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">

                        <th class="px-6 py-4">
                            Member
                        </th>

                        <th class="px-6 py-4">
                            Whatsapp
                        </th>

                        <th class="px-6 py-4">
                            Bergabung
                        </th>

                        <th class="px-6 py-4 text-center">
                            Program
                        </th>

                        <th class="px-6 py-4 text-right">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">

                    @forelse($members as $member)

                    <tr class="hover:bg-slate-50 transition">

                        {{-- Member --}}
                        <td class="px-6 py-5">

                            <div class="font-semibold text-slate-900">
                                {{ $member->name }}
                            </div>

                        </td>

                        {{-- Whatsapp --}}
                        <td class="px-6 py-5 whitespace-nowrap text-slate-700">
                            {{ $member->whatsapp }}
                        </td>

                        {{-- Join Date --}}
                        <td class="px-6 py-5 whitespace-nowrap">

                            <div class="font-medium text-slate-800">
                                {{ $member->created_at->format('d M Y') }}
                            </div>

                            <div class="text-xs text-slate-500">
                                {{ $member->created_at->diffForHumans() }}
                            </div>

                        </td>

                        {{-- Program Count --}}
                        <td class="px-6 py-5 text-center">

                            @if($member->programs_count)

                                <span class="inline-flex min-w-[42px] justify-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                    {{ $member->programs_count }}
                                </span>

                            @else

                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-500">
                                    0
                                </span>

                            @endif

                        </td>

                        {{-- Action --}}
                        <td class="px-6 py-5 text-right">

                            <button
                                wire:click="showPrograms({{ $member->id }})"
                                class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800 cursor-pointer">

                                Lihat Program

                            </button>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="px-6 py-14 text-center text-slate-500">

                            Tidak ada data member.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">

            {{ $members->links() }}

        </div>

    </div>

    @if($showProgramModal)

    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-5">

        <div class="w-full max-w-4xl rounded-3xl bg-white shadow-2xl overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b px-8 py-6">

                <div>

                    <h2 class="text-2xl font-bold text-slate-900">

                        {{ $selectedMember->name }}

                    </h2>

                    <p class="text-sm text-slate-500">

                        {{ $selectedMember->whatsapp }}

                    </p>

                </div>

                <button
                    wire:click="closeProgramModal"
                    class="rounded-xl bg-slate-100 px-4 py-2 hover:bg-slate-200">

                    ✕

                </button>

            </div>

            <div class="max-h-[70vh] overflow-y-auto">

                @forelse($memberPrograms as $program)

                    <div class="flex items-center justify-between border-b border-slate-100 px-8 py-5 hover:bg-slate-50 transition">

                        <div>

                            <h3 class="font-semibold text-slate-900">
                                {{ $program->title }}
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ \Carbon\Carbon::parse($program->start_date)->translatedFormat('d M Y') }}
                                —
                                {{ \Carbon\Carbon::parse($program->end_date)->translatedFormat('d M Y') }}
                            </p>

                        </div>

                        <a
                            href="{{ route('program.show', $program->id) }}"
                            class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition">

                            Show

                        </a>

                    </div>

                @empty

                    <div class="py-16 text-center text-slate-400">

                        Member belum mengikuti program.

                    </div>

                @endforelse

            </div>

        </div>

    </div>

    @endif

</div>