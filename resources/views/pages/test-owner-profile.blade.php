@extends('layouts.app')

@section('title', 'Testing Owner Profile')

@section('content')
    <div class="container" style="padding: 40px 0;">
        <h1>Testing Owner Profile Links</h1>

        <div style="background: #f0f0f0; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3>✓ Route Status</h3>
            <p><strong>Route Name:</strong> owner.profile</p>
            <p><strong>URL Pattern:</strong> /owner/{id}</p>
            <p style="color: green; font-weight: bold;">✓ Route is correctly configured</p>
        </div>

        <h3>Available Owner Profiles:</h3>
        <div style="display: grid; gap: 15px;">
            @if(isset($owners) && $owners->count() > 0)
                @foreach($owners as $owner)
                    <div style="background: white; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
                        <h4>{{ $owner->name }} (ID: {{ $owner->id }})</h4>
                        <p>Email: {{ $owner->email }}</p>
                        <p>Homestays: {{ $owner->homestays->count() }}</p>
                        <a href="{{ route('owner.profile', $owner->id) }}"
                            style="display: inline-block; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;">
                            View Profile
                        </a>
                        <code
                            style="display: block; margin-top: 10px; font-size: 12px;">{{ route('owner.profile', $owner->id) }}</code>
                    </div>
                @endforeach
            @else
                <p style="color: red;">No owners found in database.</p>
                <p>Please create some owner users and homestays first.</p>
            @endif
        </div>
    </div>
@endsection