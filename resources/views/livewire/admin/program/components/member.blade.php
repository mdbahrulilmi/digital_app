<div class="flex items-center justify-between mb-4">
          <h2 class="text-sm font-semibold text-slate-800">Daftar member <span class="text-[10px] text-slate-400 bg-slate-50 px-2 py-0.5 rounded-full">{{ $members->total() }}</span></h2>
          <input type="text" wire:model.live.debounce.300ms="searchMember" placeholder="Cari nama..." class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 outline-none w-48">
      </div>
      <table class="w-full text-sm text-left">
        <thead class="text-slate-400 uppercase text-[10px]">
          <tr><th class="pb-3">Nama</th><th class="pb-3">No Whatsapp</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @foreach($members as $member)
            <tr class="hover:bg-slate-50"><td class="py-3 font-medium text-slate-700">{{ $member->name }}</td><td class="py-3 text-slate-500">{{ $member->whatsapp }}</td></tr>
          @endforeach
        </tbody>
      </table>
<div class="mt-4">{{ $members->links() }}</div>