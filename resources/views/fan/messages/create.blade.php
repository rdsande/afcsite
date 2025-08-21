@extends('layouts.app')

@section('title', 'Send Message')

@section('content')
<div class="uk-container uk-container-small uk-margin-top">
    <!-- Header -->
    <div class="uk-text-center uk-margin-bottom">
        <h1 class="uk-heading-small">Send Message</h1>
        <p class="uk-text-muted">Get in touch with the AZAM FC team</p>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="uk-alert-danger" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <ul class="uk-list uk-margin-remove">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="uk-alert-danger" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Message Form -->
    <div class="uk-card uk-card-default uk-card-body">
        <form action="{{ route('fan.messages.store') }}" method="POST" class="uk-form-stacked">
            @csrf
            
            <!-- Subject -->
            <div class="uk-margin">
                <label class="uk-form-label" for="subject">Subject *</label>
                <div class="uk-form-controls">
                    <input class="uk-input @error('subject') uk-form-danger @enderror" 
                           id="subject" name="subject" type="text" 
                           placeholder="Brief description of your message"
                           value="{{ old('subject') }}" required>
                </div>
                @error('subject')
                    <div class="uk-text-danger uk-text-small uk-margin-small-top">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category -->
            <div class="uk-margin">
                <label class="uk-form-label" for="category">Category *</label>
                <div class="uk-form-controls">
                    <select class="uk-select @error('category') uk-form-danger @enderror" 
                            id="category" name="category" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('category')
                    <div class="uk-text-danger uk-text-small uk-margin-small-top">{{ $message }}</div>
                @enderror
            </div>

            <!-- Priority -->
            <div class="uk-margin">
                <label class="uk-form-label" for="priority">Priority *</label>
                <div class="uk-form-controls">
                    <select class="uk-select @error('priority') uk-form-danger @enderror" 
                            id="priority" name="priority" required>
                        <option value="">Select priority level</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
                @error('priority')
                    <div class="uk-text-danger uk-text-small uk-margin-small-top">{{ $message }}</div>
                @enderror
                <div class="uk-text-small uk-text-muted uk-margin-small-top">
                    <strong>Priority Guidelines:</strong><br>
                    • <strong>Low:</strong> General questions, suggestions<br>
                    • <strong>Medium:</strong> Account issues, event inquiries<br>
                    • <strong>High:</strong> Urgent technical problems, complaints
                </div>
            </div>

            <!-- Message -->
            <div class="uk-margin">
                <label class="uk-form-label" for="message">Message *</label>
                <div class="uk-form-controls">
                    <textarea class="uk-textarea @error('message') uk-form-danger @enderror" 
                              id="message" name="message" rows="8" 
                              placeholder="Please provide detailed information about your inquiry..."
                              required>{{ old('message') }}</textarea>
                </div>
                @error('message')
                    <div class="uk-text-danger uk-text-small uk-margin-small-top">{{ $message }}</div>
                @enderror
                <div class="uk-text-small uk-text-muted uk-margin-small-top">
                    <span id="char-count">0</span>/2000 characters
                </div>
            </div>

            <!-- Guidelines -->
            <div class="uk-alert-primary uk-margin" uk-alert>
                <h4>Message Guidelines</h4>
                <ul class="uk-list uk-list-bullet uk-margin-small">
                    <li>Be clear and specific about your inquiry</li>
                    <li>Include relevant details (dates, order numbers, etc.)</li>
                    <li>Use appropriate language and tone</li>
                    <li>You can send up to 5 messages per hour</li>
                    <li>We typically respond within 24-48 hours</li>
                </ul>
            </div>

            <!-- Form Actions -->
            <div class="uk-margin uk-flex uk-flex-between uk-flex-middle">
                <a href="{{ route('fan.messages.index') }}" class="uk-button uk-button-default">
                    <span uk-icon="arrow-left"></span> Cancel
                </a>
                <button type="submit" class="uk-button uk-button-primary">
                    <span uk-icon="mail"></span> Send Message
                </button>
            </div>
        </form>
    </div>

    <!-- Contact Information -->
    <div class="uk-card uk-card-muted uk-card-body uk-margin-top">
        <h4>Alternative Contact Methods</h4>
        <div class="uk-grid-small uk-child-width-1-2@s" uk-grid>
            <div>
                <p class="uk-text-small">
                    <span uk-icon="phone" class="uk-margin-small-right"></span>
                    <strong>Phone:</strong> +255 123 456 789
                </p>
            </div>
            <div>
                <p class="uk-text-small">
                    <span uk-icon="mail" class="uk-margin-small-right"></span>
                    <strong>Email:</strong> support@azamfc.co.tz
                </p>
            </div>
            <div>
                <p class="uk-text-small">
                    <span uk-icon="location" class="uk-margin-small-right"></span>
                    <strong>Office:</strong> Chamazi Stadium, Dar es Salaam
                </p>
            </div>
            <div>
                <p class="uk-text-small">
                    <span uk-icon="clock" class="uk-margin-small-right"></span>
                    <strong>Hours:</strong> Mon-Fri 8AM-5PM
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Character counter for message textarea
    document.getElementById('message').addEventListener('input', function() {
        const charCount = this.value.length;
        const counter = document.getElementById('char-count');
        counter.textContent = charCount;
        
        // Change color based on character count
        if (charCount > 1800) {
            counter.style.color = '#f0506e'; // danger
        } else if (charCount > 1500) {
            counter.style.color = '#faa05a'; // warning
        } else {
            counter.style.color = '#666'; // default
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const subject = document.getElementById('subject').value.trim();
        const category = document.getElementById('category').value;
        const priority = document.getElementById('priority').value;
        const message = document.getElementById('message').value.trim();
        
        if (!subject || !category || !priority || !message) {
            e.preventDefault();
            UIkit.notification({
                message: 'Please fill in all required fields.',
                status: 'warning',
                pos: 'top-right'
            });
            return false;
        }
        
        if (message.length < 10) {
            e.preventDefault();
            UIkit.notification({
                message: 'Message must be at least 10 characters long.',
                status: 'warning',
                pos: 'top-right'
            });
            return false;
        }
    });
</script>
@endsection