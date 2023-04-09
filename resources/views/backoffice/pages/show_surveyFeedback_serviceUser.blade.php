@extends('backoffice.layouts.layout')
@section('title')
    Show Service Users Survey Feedback
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
                            <select class="form-select" id="serviceUserSelectMonthID" aria-label="Month"  onchange="serviceUserSelectMonthFunc()">
                                <?php
                                    $selected_month = date('m'); //current month
                                    for ($i_month = 1; $i_month <= 12; $i_month++) { 
                                        $selected = $selected_month == $i_month ? ' selected' : '';
                                        echo '<option value="'.$i_month.'"'. $selected. '>'. date('F', mktime(0,0,0,$i_month)).'</option>'."\n";
                                    }
                                ?>
                            </select>
                            <label for="serviceUserSelectMonthID">Month</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="serviceUserSelectYearID" aria-label="Year"   onchange="serviceUserSelectYearFunc()">
                               <?php 
                                    $year_start  = 2020;
                                    $year_end =  date('Y'); 
                                    $selected_year = $year_end; // current Year
                                    for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                                        $selected = $selected_year == $i_year ? ' selected' : '';
                                        echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
                                    }
                               ?>

                            </select>
                            <label for="serviceUserSelectYearID">Year</label>
                        </div>
                    </div>
                    {{--  Table is shown here --}}
                    <div class="col-md-12 mt-2 border border-top">
                        <table   class="table table-striped"   id="serviceUserSurveyFeedbackTableID">
                            <thead>
                                <tr>
                                    <th> Name </th>
                                    <th> Address </th>
                                     <th> Telephone </th>
                                    <th> Status - Action</th>
                                </tr>
                            </thead>
                            <?php 
                                $userNameArray=[];
                                $userAddressArray=[];
                                $userTelArray=[];
                                $userProxyArray=[];
                                $company_setting=$company_settings[0]; 
                                $preText=$company_setting->surveyServiceUserText;

                                foreach($usersDetails as $userDetails){
                                    $userNameArray[$userDetails->userID]=$userDetails->title . ' ' . $userDetails->firstName . ' ' . $userDetails->lastName;
                                    $userAddressArray[$userDetails->userID]=$userDetails->address;
                                    $userTelArray[$userDetails->userID]=$userDetails->tel;
                                    $userProxyArray[$userDetails->userID]=$userDetails->proxy;
                                }
                            ?>
                            <tbody>
                                @foreach($responseStatus as $response)
                                    <tr>
                                        <?php 
                                            //1. Just created   2. Not yet received  3. Received 
                                            $status="";
                                            $btn_color="";
                                            $btn_icon="";
                                            $statusID=0;
                                            if ($response->date_posted == null){
                                                $status="Created, not sent - now send";
                                                $btn_color="text-primary";
                                                $btn_icon="bi bi-send";
                                                $statusID=1;
                                            }elseif ($response->date_received == null){
                                                $status= "Sent, no response - may resend";
                                                $btn_color="text-warning";
                                                $btn_icon="bi bi-send-plus-fill";
                                                $statusID=2;
                                            }else {
                                                $status= "Response received - may view";
                                                $btn_color="text-success";
                                                $btn_icon="bi bi-eye";
                                                $statusID=3;                       
                                            } 
                                            //If there is proxy, warn on the telephone
                                            $proxyColor="";
                                            if ($userProxyArray[$response->userID]==1){
                                                $proxyColor="text-warning";
                                            }
                                        ?>
                                        
                                        <td> {{$userNameArray[$response->userID]}} </td>
                                        <td> {{$userAddressArray[$response->userID]}} </td>
                                        <td> 
                                            <span class="{{$proxyColor}}">  {{$userTelArray[$response->userID]}} </span>   
                                        </td>
                                        <td> 
                                           <span style="cursor:pointer" onClick="surveyServiceuserFunc({{$response->userID}},{{$statusID}}, {{$response->responseTypeID}},   '{{$response->unique_value}}',   {{$response->sentCount}},    '{{$userTelArray[$response->userID]}}' )">   {{$status}}  <i class="{{$btn_icon}}  {{$btn_color}}"></i> </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>   
                    </div>    

                </form>
            </div>
        </div>  
        <script>
            let token = "{{ csrf_token() }}";
            let serviceUser_sendSMSURL= "{{ url('utility/user_sendsms')}}"; 
            let URLbase="{{ url('')}}";
            let smsPreText= @json($preText);
          
            let user_viewURL= "{{ url('user/view_feedback')}}"; 
        </script>

    @endsection    