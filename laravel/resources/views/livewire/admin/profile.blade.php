<div>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
            <div class="pd-20 card-box height-100-p">
                <div class="profile-photo">
                    <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i
                            class="fa fa-pencil"></i></a>
                    <img src="{{ $user->picture }}" alt="" class="avatar-photo">
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body pd-5">
                                    <div class="img-container">
                                        <img id="image" src="vendors/images/photo2.jpg" alt="Picture">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" value="Update" class="btn btn-primary">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="text-center h5 mb-0">{{ $user->name }}</h5>
                <p class="text-center text-muted font-14">
                    {{ $user->email }}
                </p>
                <div class="profile-social">
                    <h5 class="mb-20 h5 text-blue">Social Links</h5>
                    <ul class="clearfix">
                        <li>
                            <a href="#" class="btn" data-bgcolor="#3b5998" data-color="#ffffff"
                               style="color: rgb(255, 255, 255); background-color: rgb(59, 89, 152);"><i
                                    class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#1da1f2" data-color="#ffffff"
                               style="color: rgb(255, 255, 255); background-color: rgb(29, 161, 242);"><i
                                    class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#007bb5" data-color="#ffffff"
                               style="color: rgb(255, 255, 255); background-color: rgb(0, 123, 181);"><i
                                    class="fa fa-linkedin"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#f46f30" data-color="#ffffff"
                               style="color: rgb(255, 255, 255); background-color: rgb(244, 111, 48);"><i
                                    class="fa fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#c32361" data-color="#ffffff"
                               style="color: rgb(255, 255, 255); background-color: rgb(195, 35, 97);"><i
                                    class="fa fa-dribbble"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#3d464d" data-color="#ffffff"
                               style="color: rgb(255, 255, 255); background-color: rgb(61, 70, 77);"><i
                                    class="fa fa-dropbox"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#db4437" data-color="#ffffff"
                               style="color: rgb(255, 255, 255); background-color: rgb(219, 68, 55);"><i
                                    class="fa fa-google-plus"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#bd081c" data-color="#ffffff"
                               style="color: rgb(255, 255, 255); background-color: rgb(189, 8, 28);"><i
                                    class="fa fa-pinterest-p"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#00aff0" data-color="#ffffff"
                               style="color: rgb(255, 255, 255); background-color: rgb(0, 175, 240);"><i
                                    class="fa fa-skype"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#00b489" data-color="#ffffff"
                               style="color: rgb(255, 255, 255); background-color: rgb(0, 180, 137);"><i
                                    class="fa fa-vine"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden">
                <div class="profile-tab height-100-p">
                    <div class="tab height-100-p">
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item">
                                <a wire:click="selectTab('personal_details')"
                                   class="nav-link {{ $tab == 'personal_details' ? 'active' : '' }}"
                                   data-toggle="tab" href="#personal_details" role="tab">Personal details</a>
                            </li>
                            <li class="nav-item">
                                <a wire:click="selectTab('update_password')"
                                   class="nav-link {{ $tab == 'update_password' ? 'active' : '' }}"
                                   data-toggle="tab" href="#update_password" role="tab">Update Password</a>
                            </li>
                            <li class="nav-item">
                                <a wire:click="selectTab('social_links')"
                                   class="nav-link {{ $tab == 'social_links' ? 'active' : '' }}"
                                   data-toggle="tab" href="#social_links" role="tab">Social Links</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade {{ $tab == 'personal_details' ? 'show active' : ''}}"
                                 id="personal_details" role="tabpanel">
                                <div class="pd-20 profile-task-wrap">
                                    <form wire:submit="updatePersonalDetails">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Full Name</label>
                                                    <input type="text" class="form-control" wire:model="name" placeholder="Введите ФИО">
                                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Email</label>
                                                            <input type="text" class="form-control" wire:model="email" placeholder="Введите Email" disabled>
                                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Username</label>
                                                            <input type="text" class="form-control" wire:model="username" placeholder="Введите Username">
                                                            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mt-3">
                                                    <label for="">Bio</label>
                                                    <textarea wire:model="bio" cols="4" rows="4" class="form-control" placeholder="bio"></textarea>
                                                    @error('bio') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">Обновить профиль</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="tab-pane fade {{ $tab == 'update_password' ? 'show active' : ''}}"
                                 id="update_password" role="tabpanel">
                                <div class="pd-20 profile-task-wrap">
                                    update password
                                </div>
                            </div>
                            <div class="tab-pane fade {{ $tab == 'social_links' ? 'show active' : ''}}"
                                 id="social_links" role="tabpanel">
                                <div class="pd-20 profile-task-wrap">
                                    social_links
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

