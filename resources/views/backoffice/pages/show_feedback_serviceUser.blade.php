@extends('backoffice.layouts.layout')
@section('title')
    Show Service Users Feedback
@endsection
@section('contents')
<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Select the criteria</h5>

                <!-- Floating Labels Form -->
                <form class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="serviceUserSelectMonthID" aria-label="Month"  onchange="serviceUserSelectMonthFunc(this)">
                                <option value="1">January</option>
                                <option value="2">Feburary</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <label for="serviceUserSelectMonthID">Month</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="serviceUserSelectYearID" aria-label="Year"   onchange="serviceUserSelectYearFunc(this)">
                                <option value="1">2022</option>
                                <option value="2">2023</option>
                                <option value="3">2024</option>
                                <option value="4">2025</option>
                                <option value="5">2026</option>
                                <option value="6">2027</option>
                                <option value="7">2028</option>
                                <option value="8">2029</option>
                                <option value="9">2030</option>

                            </select>
                            <label for="serviceUserSelectYearID">Year</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>   

@endsection    