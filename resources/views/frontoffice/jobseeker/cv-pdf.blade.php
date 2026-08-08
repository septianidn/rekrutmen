<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CV - {{ $user->first_name }} {{ $user->last_name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 12px; color: #333; line-height: 1.5; padding: 30px 40px; }

        .header { border-bottom: 3px solid #2563eb; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { font-size: 26px; color: #1e293b; margin-bottom: 2px; }
        .header .subtitle { font-size: 13px; color: #64748b; }
        .header .contact { margin-top: 8px; font-size: 11px; color: #475569; }
        .header .contact span { margin-right: 15px; }

        .section { margin-bottom: 18px; }
        .section-title { font-size: 14px; font-weight: 700; color: #2563eb; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; margin-bottom: 10px; }

        .item { margin-bottom: 10px; }
        .item-title { font-weight: 600; font-size: 12px; color: #1e293b; }
        .item-subtitle { font-size: 11px; color: #64748b; }
        .item-desc { font-size: 11px; color: #475569; margin-top: 2px; }

        .badge { display: inline-block; background: #e0e7ff; color: #3730a3; padding: 1px 8px; border-radius: 3px; font-size: 10px; font-weight: 600; }

        .two-col { display: table; width: 100%; }
        .two-col .col { display: table-cell; width: 50%; vertical-align: top; padding-right: 15px; }

        .lang-list { list-style: none; }
        .lang-list li { display: inline-block; background: #f1f5f9; padding: 3px 10px; margin: 2px 4px 2px 0; border-radius: 3px; font-size: 11px; }

        .ref-item { margin-bottom: 8px; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
        @if($jobseeker->jenis_kelamin && $jobseeker->jenis_kelamin != '-')
            <div class="subtitle">{{ $jobseeker->jenis_kelamin }} @if($jobseeker->ttl) &middot; {{ $jobseeker->ttl->format('d M Y') }} @endif</div>
        @endif
        <div class="contact">
            <span>{{ $user->email }}</span>
            @if($user->phone_number)<span>{{ $user->phone_number }}</span>@endif
            @if($user->street_addr)<span>{{ $user->street_addr }}</span>@endif
        </div>
    </div>

    <!-- Riwayat Pendidikan -->
    @if($jobseeker->riwayatPendidikans->isNotEmpty())
    <div class="section">
        <div class="section-title">Riwayat Pendidikan</div>
        @foreach($jobseeker->riwayatPendidikans as $edu)
        <div class="item">
            <span class="badge">{{ $edu->jenjang?->nama_jenjang }}</span>
            <span class="item-title">{{ $edu->instansi }}</span>
            @if($edu->indeks_nilai)
                <span class="item-subtitle">&mdash; IPK: {{ $edu->indeks_nilai }}</span>
            @endif
            @if($edu->keterangan)
                <div class="item-desc">{{ $edu->keterangan }}</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- Pengalaman Kerja -->
    @if($jobseeker->riwayatKerjas->isNotEmpty())
    <div class="section">
        <div class="section-title">Pengalaman Kerja</div>
        @foreach($jobseeker->riwayatKerjas as $work)
        <div class="item">
            <div class="item-desc">{{ $work->keterangan }}</div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="two-col">
        <div class="col">
            <!-- Organisasi -->
            @if($jobseeker->organisasis->isNotEmpty())
            <div class="section">
                <div class="section-title">Organisasi</div>
                @foreach($jobseeker->organisasis as $org)
                <div class="item">
                    <div class="item-title">{{ $org->nama_organisasi }}</div>
                    <div class="item-subtitle">{{ $org->jabatan }}</div>
                    @if($org->keterangan)
                        <div class="item-desc">{{ $org->keterangan }}</div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <!-- Prestasi -->
            @if($jobseeker->prestasis->isNotEmpty())
            <div class="section">
                <div class="section-title">Prestasi / Penghargaan</div>
                @foreach($jobseeker->prestasis as $award)
                <div class="item">
                    <span class="item-title">{{ $award->nama_penghargaan }}</span>
                    <span class="item-subtitle">({{ $award->tahun }})</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="col">
            <!-- Pelatihan -->
            @if($jobseeker->pelatihans->isNotEmpty())
            <div class="section">
                <div class="section-title">Pelatihan / Sertifikasi</div>
                @foreach($jobseeker->pelatihans as $training)
                <div class="item">
                    <span class="item-title">{{ $training->nama_pelatihan }}</span>
                    <span class="item-subtitle">({{ $training->tahun }})</span>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Bahasa -->
            @if($jobseeker->bahasas->isNotEmpty())
            <div class="section">
                <div class="section-title">Bahasa</div>
                <ul class="lang-list">
                    @foreach($jobseeker->bahasas as $lang)
                    <li>{{ $lang->bahasa }} @if($lang->keterangan)({{ $lang->keterangan }})@endif</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

    <!-- Referensi -->
    @if($jobseeker->rekomendasis->isNotEmpty())
    <div class="section">
        <div class="section-title">Referensi</div>
        <div class="two-col">
        @foreach($jobseeker->rekomendasis as $ref)
            <div class="col ref-item">
                <div class="item-title">{{ $ref->nama_perekomendasi }}</div>
                <div class="item-subtitle">{{ $ref->posisi }}</div>
                <div class="item-desc">{{ $ref->no_hp }} &middot; {{ $ref->alamat }}</div>
            </div>
        @endforeach
        </div>
    </div>
    @endif
</body>
</html>
