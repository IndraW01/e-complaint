@props([
    'order' => '',
])

<li {{ $attributes->class(['mb-2 d-flex']) }}>
    <div class="d-flex">
        <img src="../../assets/images/avatars/03.png" alt="userimg"
            class="avatar-50 p-1 pt-2 bg-soft-primary rounded-pill img-fluid {{ $order }}">
        {{ $slot }}
    </div>
</li>
