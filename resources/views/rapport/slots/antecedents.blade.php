{{--@if(count($antecedents) >0)--}}
    <h4 class="sous-titre-rapport--table">Antédédents</h4>
    <div class="divTable">
        <div class="divTableBody">
            <div class="divTableRow">

                <div class="divTableCell">
                    <table>
                        <thead>
                        <td class="title-table">Type</td>
                        <td class="title-table">Description</td>
                        <td class="title-table">Date debut</td>
                        </thead>
                        <tbody>
                        <tr></tr>
                        @forelse($antecedents as $antecedent)
                            <tr>
                                <td>{{$antecedent->type}}</td>
                                <td>{{$antecedent->description}}</td>
                                <td>{{\Carbon\Carbon::parse($antecedent->date)->format('d/m/Y')}}</td>
                            </tr>
                        @empty
                            <strong></strong>
                        @endforelse
{{--                        @foreach($dossier->consultationsMedecine as $consultationMedecine)--}}
{{--                            @if(\Carbon\Carbon::parse($consultationMedecine->updated_at)->lessThan($consultation->updated_at))--}}
{{--                                @foreach($consultationMedecine->conclusions as $conclusion)--}}
{{--                                    @if(!is_null($conclusion->description) && $conclusion->description !=='null')--}}
{{--                                        <tr>--}}
{{--                                            <td>Consultation</td>--}}
{{--                                            <td>{!! $conclusion->description !!}</td>--}}
{{--                                            <td>{{\Carbon\Carbon::parse($conclusion->updated_at)->format('d/m/Y')}}</td>--}}
{{--                                        </tr>--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                        @foreach($dossier->cardiologies as $cardiologie)--}}
{{--                            @if(\Carbon\Carbon::parse($cardiologie->updated_at)->lessThan($consultation->updated_at))--}}
{{--                                @if(!is_null($cardiologie->conclusion) && $cardiologie->conclusion !=='null')--}}
{{--                                    <tr>--}}
{{--                                        <td>Consultation</td>--}}
{{--                                        <td>{!!  $cardiologie->conclusion !!}</td>--}}
{{--                                        <td>{{\Carbon\Carbon::parse($cardiologie->updated_at)->format('d/m/Y')}}</td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
{{--@endif--}}
