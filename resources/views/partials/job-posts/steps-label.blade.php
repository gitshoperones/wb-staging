<ul class="nav nav-tabs">
    <li class="active">
        <a id="step-1-section" href="#step-1" data-toggle="tab">Step 1</a>
    </li>
    <li>
        <a id="step-2-section" href="#step-2" data-toggle="tab">Step 2</a>
    </li>
    <li>
        <a id="step-3-section" href="#step-3" data-toggle="tab">Step 3</a>
    </li>
    <li class="images_option" style="display:none;">
        <a id="step-4-section" href="#step-4" data-toggle="tab">Step 4</a>
    </li> 
    @if(request()->vendor_id)
    <li>
        <a id="step-5-section" href="#step-5" data-toggle="tab">Step 4</a>
    </li>
        @guest
        <li>
            <a id="step-6-section" href="#step-6" data-toggle="tab">Step 5</a>
        </li>
        @endguest
    @else
        @guest
        <li>
            <a id="step-5-section" href="#step-5" data-toggle="tab">Step 4</a>
        </li>
        @endguest
    @endif

</ul>