<!-- Start Planning Modal -->
<div class="modal fade" id="start-planning-select" tabindex="-1" role="dialog" aria-labelledby="requiredFields" aria-hidden="true">
    <div class="modal-dialog start-planning-select">
        <div class="modal-content text-center">
            <div class="modal-body row text-center text-primary">
                <form method="GET" id="quote-next">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <dl class="selectdropdown">
                            <dt>
                                <a class="dropdown">
                                    <p class="multiSel" id="vendor-category-selection">
                                        <span title="wedBooker">What do you need?</span>
                                        <span class="categs"></span>
                                    </p>
                                    <i class="fa fa-caret-down text-primary pull-right"></i>
                                </a>
                            </dt>
                            <dd>
                                <div class="mutliSelect">
                                    <ul>
                                        @foreach ($categories as $category)
                                        <li>
                                            <input type="radio"
                                            name="category"
                                            id="headCat{{ $category['name'] }}"
                                            value="{{ $category['name'] }}" />
                                            <label for="headCat{{ $category['name'] }}">{{ $category['name'] }}</label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                        <dl class="selectdropdown">
                            <dt>
                                <a class="dropdown">
                                    <p class="multiSel" id="vendor-location-selection">
                                        <span title="wedBooker">Where do you need it?</span>
                                    </p>
                                    <i class="fa fa-caret-down pull-right"></i>
                                </a>
                            </dt>
                            <dd>
                                <div class="mutliSelect">
                                    <ul>
                                        @foreach ($locationsByState as $states)
                                            @foreach ($states as $key1 => $locs)
                                                @if($key1 != 'Australia Wide')
                                                    <li class="statename">
                                                        <div class="toggleLocations text-primary">
                                                            {{ $key1 }} <i class="fa fa-plus"></i>
                                                        </div>
                                                        <ul class="stateunder">
                                                            @foreach ($locs as $key2 => $loc)
                                                            <li>
                                                                <input type="checkbox"
                                                                name="locations[]"
                                                                id="headloc{{ $key1.$key2 }}"
                                                                value="{{ $loc['name'] }}" />
                                                                <label for="headloc{{ $key1.$key2 }}">{{ $loc['name'] }}</label>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            </dd>
                        </dl>
                        <a data-toggle="modal" data-target="#start-planning" data-dismiss="modal" class="btn wb-btn-orange quote-next">Next</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>