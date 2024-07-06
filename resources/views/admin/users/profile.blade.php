@extends('admin.layout.main')

@section('content')
<div class="container">
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-4">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('template/admin_asset/profile-image/301648796_1164584951074067_594328778084010935_n (2).jpg') }}" alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Họ tên</b>
                                        <div class="float-right text-secondary">
                                            {{ $user->name }}
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                                <b>Email</b>
                                            <div class="float-right text-secondary">
                                                {{ $user->email }}
                                            </div>
                                    </li>
                                    @php
                                        $rolePms = collect();
                                    @endphp
                                    <li class="list-group-item">
                                        <b>Vai trò</b> <a class="float-right">
                                            @foreach ($userRoles as $us)
                                                <span class="badge badge-primary">{{ $us->name }}</span>
                                                @php
                                                    /* Gộp 2 mảng Collection chứa role thuộc permission vào lại với nhau */
                                                    $rolePms = $rolePms->merge($us->permissions);
                                                @endphp
                                            @endforeach
                                        </a>
                                    </li>
                                    @php
                                        // dd($rolePms);
                                    @endphp
                                    <li class="list-group-item">
                                        <b>Quyền</b> <a class="float-right">
                                            @foreach($rolePms as $rp)
                                                <span class="badge badge-primary">{{ $rp->name }}</span>
                                            @endforeach
                                        </a>
                                    </li>
                                    {{-- <button type="submit" class="btn btn-primary btn-block"><b>Edit</b></button> --}}
                                    {{-- {!! \App\Helpers\Helper::update('user.update', auth()->user()->id, 
                                        'Cập nhật profile', 'Chỉnh sửa', 'Cập nhật') !!} --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>

</div>
@endsection
