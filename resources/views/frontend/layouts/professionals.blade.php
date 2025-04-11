<div class="card mt-4">
    <div class="card-body professionals">
        <h4 class="text-gray-800 mb-4">Featured Professionals</h4>
        <div class="row g-4">
            @foreach($professionals as $professional)
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="symbol symbol-50px me-3">
                                <img src="{{ $professional->profile_image_url }}" class="rounded-circle" alt="{{ $professional->user->name }}">
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $professional->user->name }}</h5>
                                <span class="text-muted">{{ $professional->title }}</span>
                            </div>
                        </div>
                        <p class="card-text">{{ Str::limit($professional->bio, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-{{ $professional->is_available ? 'primary' : 'danger' }}">
                                {{ $professional->is_available ? 'Available for Hire' : 'Not Available' }}
                            </span>
                            <button class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#professionalModal{{ $professional->id }}">
                                View Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Profile Modal -->
            <div class="modal fade" id="professionalModal{{ $professional->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{ $professional->user->name }}'s Profile</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img src="{{ $professional->profile_image_url }}" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="{{ $professional->user->name }}">
                                    <h4 class="mb-1">{{ $professional->user->name }}</h4>
                                    <p class="text-muted mb-3">{{ $professional->title }}</p>
                                    <div class="d-flex justify-content-center gap-2 mb-3">
                                        <span class="badge bg-primary">{{ $professional->specialization }}</span>
                                        <span class="badge bg-info">{{ $professional->experience_years }} years experience</span>
                                    </div>
                                    <div class="text-center">
                                        <h5 class="mb-1">Hourly Rate</h5>
                                        <p class="text-primary fw-bold">${{ number_format($professional->hourly_rate, 2) }}/hr</p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="mb-3">About</h4>
                                    <p class="text-gray-600 mb-4">{{ $professional->bio }}</p>
                                    
                                    <h4 class="mb-3">Qualifications</h4>
                                    <p class="text-gray-600 mb-4">{{ $professional->qualification }}</p>

                                    <h4 class="mb-3">Services</h4>
                                    <div class="table-responsive">
                                        <table class="table table-row-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Calculator</th>
                                                    <th>Description</th>
                                                    <th>Rate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($professional->services as $service)
                                                <tr>
                                                    <td>{{ Str::title(str_replace('_', ' ', $service->calculator_type)) }}</td>
                                                    <td>{{ $service->service_description }}</td>
                                                    <td>${{ number_format($service->service_rate, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('professionals.consult', $professional) }}" method="POST" class="w-100">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" name="message" rows="3" placeholder="Describe your needs..." required></textarea>
                                </div>
                                @guest
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Your Name</label>
                                        <input type="text" class="form-control" name="guest_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Your Email</label>
                                        <input type="email" class="form-control" name="guest_email" required>
                                    </div>
                                </div>
                                @endguest
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Request Consultation</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body professional_signup">
        <div class="text-center">
            <h4 class="text-gray-800 mb-4">Become a Professional</h4>
            <p class="text-gray-600 mb-4">Share your expertise and help businesses make better decisions.</p>
            <div class="d-flex flex-column align-items-center">
                <div class="mb-4">
                    <i class="ki-duotone ki-profile-user fs-2x text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <h5 class="text-gray-800 mb-3">Why Join as a Professional?</h5>
                <ul class="text-start text-gray-600 mb-4">
                    <li>Connect with businesses seeking your expertise</li>
                    <li>Build your professional portfolio</li>
                    <li>Earn income through consulting services</li>
                    <li>Access premium tools and resources</li>
                </ul>
                <a href="{{ route('professionals.become') }}" class="btn btn-primary">
                    Sign Up as a Professional
                </a>
            </div>
        </div>
    </div>
</div>