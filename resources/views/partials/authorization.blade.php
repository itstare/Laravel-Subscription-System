@if(isset($errors) && $errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">
                    <ul>
                        @foreach(session()->get('success') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif