<?php
/** @var \App\Models\Site $site */
?>

<script>
    function confirmDelete(){
        return{
            openModal: false,
            shouldSend: false,

            submitForm(){
                console.log(this.shouldSend)
                return this.shouldSend
            }
        }
    }
</script>

<tr class="border-b border-gray-300 p-3">
    <td>
        <a href="{{ url(route('sites.update', ['site' => $site])) }}">{{ $site->getUrl() }}</a>
    </td>
    <td class="text-center">
        <x-confirm-modal-delete :url="route('sites.delete', ['site' => $site])" :content="$site->getUrl()"></x-confirm-modal-delete>
    </td>
</tr>


