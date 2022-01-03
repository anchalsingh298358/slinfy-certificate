<html>
<head>
    <title></title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet">

    <script src="{{url('/public/admin/assets/plugins/jquery/jquery.min.js')}}"></script>

    <link href="{{url('public/admin/assets/css/certificate.css')}}" rel="stylesheet" />
    <script>
        // var is_chrome = function () { return Boolean(window.chrome); }
        // if (is_chrome) {
        //     window.print();
        //     setTimeout(function () { window.close(); }, 10000);
        //     //give them 10 seconds to print, then close
        // }
        // else {
        //     window.print();
        //     window.close();
        // }
    </script>

    <style type="text/css">
        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari, Edge */
            color-adjust: exact !important;                 /*Firefox*/
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
        @page {
          size: A4;
          margin: 0;
        }
    </style>
    
</head>

<page size="A4">

    <div class="main print">
        <div class="logo" id="wave">
            <img src="{{ asset('public/images/certificate/logo.png') }}">
        </div>
        <div class="content">
            <div class="uppart">
                <p id="sno">S.No. {{ isset($user) ? $user->id : '' }}</p>
                        <p id="date">Date : {{ isset($user) ? $user->date : '' }}</p>
                    </div>

                    <h1 align="center" class="cert">Certificate of Training</h1>

                    <div class="dpart">
                        <p class="part1">

                         This certificate has been awarded to 
                         @if(isset($user) && $user->gender == 'Male') Mr
                         @elseif($user->gender == 'Female')  Mrs
                         @else Mr/Ms
                         @endif
                         <b><span class="dtext"> {{ isset($user) ? $user->name : '' }} </span></b>  from  <span class="dtext"> Passout from {{ isset($user) ? $user->college_name : '' }} </span> who has undertaken an internship program of <span class="dtext">{{ isset($user) ? $user->course : '' }}</span> from <span class="dtext"> {{ isset($user) ? date('d/m/Y', strtotime($user->date_from)) : '' }} </span>  to <span class="dtext"> {{ isset($user) ? date('d/m/Y', strtotime($user->date_to)) : '' }} </span>
                         in
                         <span class="dtext"> {{ isset($user->getDepartment->name) ? $user->getDepartment->name : '' }} </span>  Department from Solitaire Infosys Pvt. Ltd.</p>
                     </div>
                     <p class ="part1">

                         During the tenure of this internship with us, we found the candidate self-starter and hardworking. Also
                         @if(isset($user) && $user->gender == 'Male') he
                         @elseif($user->gender == 'Female')  she
                         @else he/she
                         @endif
                         
                         had worked sincerely on the  assignments and  

                         @if(isset($user) && $user->gender == 'Male') his
                         @elseif($user->gender == 'Female')  her
                         @else his/her
                         @endif

                         performance was satisfactory to be part of the team.

                     </p>

                     <p class="part1">
                        We wish the Candidate success for all the future endeavors.

                    </p>

                    <h3 id="bottompart">For Solitaire Infosys Pvt. Ltd.</h3>
                    <span id="sign1">
                        <img src="{{ asset('public/images/certificate/cert.png') }}"></span>
                        <h3 style="font-size: 24px; font-weight: 650;" id="hr">Human Resources Department
                         <div class="layer">
                           <img src="{{ asset('public/images/certificate/layer3.png') }}" height="150" width="170">
                       </div></h3>

                       <p id="notepart">Note:  To check the authentication of certificate, please visit www.slinfy.com </p>
                   </div>
                   <div class="footer">
                   </div>
               </div>
           </page>


       </body>
       </html>
