@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                  
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Expenses</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary " onclick="event.preventDefault();
                    document.getElementById('expenses-form').submit();"><i class="icon-copy fi-save"></i> Save</button>
                    <a class="btn btn-secondary text-white" href="/expenses"><i class="icon-copy fi-x"></i> Cancel</a>

                </div>
            </div>
        </div>
       
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h5 class="text-blue">Expense Information</h5>
                </div>
            </div>
            <div class="container">
               
                <form id="expenses-form" action="{{ $action }}" method="POST" >
                    @csrf


                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Type</label>
                        <div class="col-sm-12 col-md-10">

                            <div class="d-none">{{ $expense_type =  isset($expense->type) ? $expense->type :  old('type') }}</div>

                            <select class="form-control" name="type">
                                @foreach ($expenses_types as $type)
                                    @if ($type['id'] == $expense_type)
                                        <option value="{{ $type['id'] }}" selected>{{ $type['name'] }}</option>
                                    @else 
                                        <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="description" type="text" placeholder="Description" value="{{ isset($expense->description) ? $expense->description :  old('description') }}">
                           
                            @error('description')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    
                    </div>
                   
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Reference</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="reference" type="text" placeholder="Reference" value="{{ isset($expense->reference) ? $expense->reference :  old('reference') }}">
                           
                            @error('reference')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    
               
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Amount</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="amount" type="number" placeholder="Amount" value="{{ isset($expense->amount) ? $expense->amount :  old('amount') }}">
                            @error('amount')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Currency</label>
                        <div class="col-sm-12 col-md-10">

                            <div class="d-none">{{ $currency =  isset($expense->currency) ? $expense->currency :  old('currency') }}</div>

                            <select class="form-control" name="currency">
                                <option value="lbp" {{ $currency == 'lbp' ? 'selected' : ''}}>LBP</option>
                                <option value="usd" {{ $currency == 'usd' ? 'selected' : ''}}>USD</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Currency Rate</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="currency_rate" type="number" placeholder="Rate" value="{{ isset($expense->currency_rate) ? $expense->currency_rate :  old('currency_rate')}}">
                            @error('currency_rate')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">VAT %</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="vat" type="number" placeholder="VAT" value="{{ isset($expense->vat) ? $expense->vat :  old('vat') }}">
                            @error('vat')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Note</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="note" type="text" placeholder="Note" value="{{ isset($expense->note) ? $expense->note :  old('note')  }}">
                           
                            @error('note')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Expense Date</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="expense_date" type="date" placeholder="Date" value="{{ isset($expense->expense_date) ? $expense->expense_date :  old('expense_date') }}">
                            @error('expense_date')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
           
                </form>
							
            </div>
        </div>
        <!-- Export Datatable End -->
    </div>
</div>

@endsection
