<?php
/** @var \App\Models\Queue $queue */
?>

<tr class="text-center">
    <td>{{ $queue->getQueue() }}</td>
    <td>{{ $queue->getTimeout() }}</td>
    <td>{{ $queue->getProcesses() }}</td>
    <td>{{ $queue->getTries() }}</td>
    <td>
        <x-confirm-modal-delete :url="route('queue.delete', ['queue' => $queue])" :content="$queue->id"></x-confirm-modal-delete>
    </td>
</tr>
