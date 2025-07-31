@props(['recordId' => $recordId])
<x-table-action-button pseudo-action="show" :record-id="$recordId" setIdFunction='setCustomerId' title='Thông tin khách hàng'
    color='info-subtle' icon='fas fa-eye' />
