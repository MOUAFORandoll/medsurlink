@forelse($motifs as $motif)
    <strong>{{$motif->description}},</strong>
@empty
    <strong></strong>
@endforelse
