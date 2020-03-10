<h4 class="sous-titre-rapport">Motif(s) de Consultation</h4>
@forelse($motifs as $motif)
    <p>{{$motif->description}}</p>
@empty
    <strong></strong>
@endforelse
