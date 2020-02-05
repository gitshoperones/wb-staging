<div id="wb-modal-invoice" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-success text-center">
          <span class="icon"><i class="fa fa-info-circle"></i></span> You have made a payment to "Anna's Florist"
        </div>
      </div>
      <div class="modal-body">
        <div class="wb-tab-invoice">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#payment_tab" data-toggle="tab">PAYMENT</a>
                </li>
                <li>
                    <a href="#invoice_tab" data-toggle="tab">INVOICE</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="payment_tab">

              <div class="row">
                <div class="col-md-6">
                  <div class="wb-payment-option-block">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <div class="radio">
                            <label><input type="radio" name="payment">Credit/Debit Cards</label>
                          </div>
                        </h4>
                      </div>
                      <div class="panel-body">
                        <form class="" action="index.html" method="post">
                          <div class="form-group">
                            <label for="">Card Name</label>
                            <input type="text" class="form-control wb-input">
                          </div>
                          <div class="form-group">
                            <label for="">Card Number</label>
                            <input type="text" class="form-control wb-input">
                          </div>
                          <div class="row">
                            <div class="col-xs-6">
                              <div class="form-group">
                                <label for="">Expiry(MM/YY)</label>
                                <input type="text" class="form-control wb-input">
                              </div>
                            </div>
                            <div class="col-xs-6">
                              <div class="form-group">
                                <label for="">Card Code(CVC)</label>
                                <input type="text" class="form-control wb-input">
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>

                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <div class="radio">
                            <label><input type="radio" name="payment"> Bank Transfer</label>
                          </div>
                        </h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">



                    <div class="wb-milestone-block">
  <div class="header">
    Job
  </div>

  <div class="content-wrapper">
    <div class="details">
      Hugo and laura Needs a Florist in Mosman
    </div>

    <div class="header">
      Payments
      <span class="pull-right">Costs</span>
    </div>
    <p class="m-t-xxs"><small>Please select the payments you would like to make</small></p>

    <ul class="list-unstyled">
        @foreach($jobQuote->milestones as $milestone)
        <li>
            <div class="checkbox">
                <input type="checkbox" id="payment_1">
                <label for="payment_1">{{ $milestone->desc }}</label>
                <span class="pull-right">{{ number_format(($milestone->percent / 100) * $jobQuote->total, 2) }}</span>
            </div>
        </li>
        @endforeach
    </ul>
    <div class="total-wrapper">
      <strong>Total</strong>(inc GST) <span class="pull-right"><strong>{{ number_format($jobQuote->total, 2) }}</strong></span>
    </div>
  </div>

</div>









                </div>
              </div>

              <div class="action-button">
                <button type="button" class="btn wb-btn-orange" data-dismiss="modal">PAY NOW</button>
              </div>

                </div>

                <div class="tab-pane" id="invoice_tab">
              <div class="row">
                <div class="col-md-6">
                  <div class="item-block">
                    <p><span class="wb-text-grey">Vendor</span></p>
                    <p class="lead">Anna's Florist</p>
                    <p>1 Buckingham Street, Surry Hills, NSW Australia 2010 Fiesta Crescent, Copacabana NSW 2251</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="item-block">
                    <span class="pull-right"><img src="{{ asset('assets/images/wedbooker-logo.png') }}" /></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="item-block">
                    <p><span class="wb-text-grey">Couple</span></p>
                    <p class="lead">Hugo & Laura's Wedding</p>
                    <p>1 Buckingham Street, Surry Hills, NSW Australia 2010
                    Fiesta Crescent, Copacabana SW 2251</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="item-block">
                    <p class="wb-text-grey">&nbsp;</p>
                    <p class="lead">Invoice Number <span class="pull-right">wb1000</span></p>
                    <p>Invoice Data <span class="pull-right">11/11/17</span></p>
                    <p>Order Amount <span class="pull-right">$1,000.00</span></p>
                  </div>
                </div>
              </div>

              <div class="wb-table-invoice">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Job</th>
                      <th>Description</th>
                      <th>Quantity</th>
                      <th class="text-right">Costs</th>
                    </tr>
                    <tbody>
                      <tr>
                        <td>Hugo & Laura Needs a Florist in Mosman</td>
                        <td>Payment 1</td>
                        <td>1</td>
                        <td class="text-right">$1,000.00</td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td></td>
                        <td><strong>Subtotal<strong></td>
                        <td></td>
                        <td class="text-right"><strong>$1,000.00<strong></td>
                      </tr>
                      <tr>
                        <td class="download"><span class="icon"><i class="fa fa-download"></i></span> <a href="#">Download Invoice</a></td>
                        <td class="total" colspan="3"><strong>Total</strong>(INC GST) <strong class="pull-right">$1,000.00</strong></td>
                      </tr>
                    </tfoot>
                  </thead>
                </table>
              </div>
            </div>

            </div>
        </div>
      </div>
    </div>
  </div>
</div>
