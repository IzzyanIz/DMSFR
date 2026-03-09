@extends('template/dashboardLawyer')
@section('title', 'Document')


@section('section')


<div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Generate Document</h2>
                                 </div>
                              </div>
                              <div class="table_section padding_infor_info">
                           
                                    <form action="{{ route('generate.loan.process') }}" method="POST">
                                            @csrf

                                            <div class="mb-4">
                                                <label class="form-label">SELECT DOCUMENT NAME:</label>
                                                <select class="form-control" name="DocumentName">
                                                    @foreach($documentsSPA as $doc)
                                                        <option value="{{ $doc->DocumentName }}">{{ $doc->DocumentName }} (v{{ $doc->version }})</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Client Name:</label>
                                                <select class="form-control" id="client_id" name="client_id">
                                                    <option value="">-- Select Client --</option>
                                                    @foreach($clients as $client)
                                                        <option value="{{ $client->idClient }}">{{ $client->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">NRIC:</label>
                                                <input type="text" class="form-control" id="ic" name="ic" >
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Property Address:</label>
                                                <input type="text" class="form-control" id="property_address" name="property_address" >
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Purchase Price (RM):</label>
                                                <input type="text" class="form-control" id="purchase_price" name="purchase_price" >
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Deposit (RM):</label>
                                                <input type="text" class="form-control" id="deposit_paid" name="deposit_paid" >
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">Generate Document</button>
                                            </div>
                                        </form> 

                                    </div>
                                    </div>
                              </div>
                           </div>
                        </div>






   <style>
  .nav-tabs .nav-link {
    color: black;
  }

  .nav-tabs .nav-link.active {
    color:rgb(0, 76, 239);
    font-weight: bold;
  }
</style>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#client_id').on('change', function () {
            var clientId = $(this).val();

            if (clientId) {
                $.ajax({
                    url: '/get-client-details/' + clientId,
                    type: 'GET',
                    success: function (data) {
                        $('#ic').val(data?.ic ?? '');
                        $('#property_address').val(data?.property_address ?? '');
                        $('#purchase_price').val(data?.purchase_price ?? '');
                        $('#deposit_paid').val(data?.deposit_paid ?? '');
                    },
                    error: function () {
                        alert('Failed to fetch client data.');
                    }
                });
            } else {
                $('#ic, #property_address, #purchase_price, #deposit_paid').val('');
            }
        });
    });
</script>
@endsection


