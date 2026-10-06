@extends('crm.layouts.master')

@section('title', 'Roles & RBAC Permissions')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800">Roles & Permissions Management</h2>
        <p class="text-xs text-slate-500 font-medium">Server-side role based access controls protecting endpoints and data tiers</p>
    </div>

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($roles as $r)
            <div class="crm-card p-6 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-2xl bg-[#1b4d3e] text-white flex items-center justify-center font-bold text-base mb-3 shadow-md">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800">{{ $r->name }}</h3>
                    <span class="text-[11px] font-mono text-slate-400 block mb-2">{{ $r->slug }}</span>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        {{ $r->description }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 mt-4">
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">
                        Server Enforced
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
