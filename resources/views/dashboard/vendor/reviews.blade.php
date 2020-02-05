@extends('layouts.dashboard')

@section('content')
    <section class="content dashboard-container" style="padding-top: 40px;">
        <form class="form-inline">
            <div class="search-box-sm">
                <label for="">Search</label>
                <div class="input-group">
                    <input type="text" placeholder="Enter keyword" class="form-control">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row row-no-padding m-b-28">
            <div class="col-sm-12">
                <div class="wb-review-box">
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">
                                            <img src="http://wedbooker-site.test/assets/images/icons/dashboard/your_reviews2.png" alt="" style="width: 20px; margin-top: -3px;">
                                            Review
                                        </th>
                                        <th style="width: 15%;">Event Date</th>
                                        <th style="width: 24%;">Review Excerpt</th>
                                        <th><span>Ease to work with</span></th>
                                        <th><span>Service on-the-day</span></th>
                                        <th><span>Overall Satisfaction</span></th>
                                        <th>Total Star Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="#">Laura &amp; Hugo</a>
                                        </td> <td>Nov 20, 2017</td>
                                        <td><a href="#" data-toggle="modal" data-target="#wb-modal-review">This vendor is good</a></td>
                                        <td>
                                            <div class="rating">
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rating">
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rating">
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rating">
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                                <a><i class="fa fa-star"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="wb-modal-review" role="dialog" class="wb-modal-review modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content text-center">
                            <div class="modal-header">
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h3 class="reviewee">Laura &amp; Hugo</h3>
                                <div class="review-date">Nov 20, 2017</div>
                            </div>
                            <div class="modal-body ">
                                <div class="rating">
                                    <a><i class="fa fa-star"></i></a>
                                    <a><i class="fa fa-star"></i></a>
                                    <a><i class="fa fa-star"></i></a>
                                    <a><i class="fa fa-star"></i></a>
                                    <a><i class="fa fa-star"></i></a>
                                </div>
                                <div class="review-entry">
                                    <p>
                                        This vendor is good Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</p>
                                    <p> Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed porttitor lectus nibh.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection