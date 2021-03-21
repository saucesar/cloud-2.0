<div class="card shadow bg-secondary">
    <div class="card-header">
        <h2>Network</h2>
    </div>
    <div class="card-body">
        <p><b>Bridge: </b>{{ $details['NetworkSettings']['Bridge'] }}</p>
        <p><b>SandboxID: </b>{{ $details['NetworkSettings']['SandboxID'] }}</p>
        <p><b>HairpinMode: </b>{{ $details['NetworkSettings']['HairpinMode'] ? 'True' : 'False' }}</p>
        <p><b>LinkLocalIPv6Address: </b>{{ $details['NetworkSettings']['LinkLocalIPv6Address'] }}</p>
        <p><b>LinkLocalIPv6PrefixLen: </b>{{ $details['NetworkSettings']['LinkLocalIPv6PrefixLen'] }}</p>
        <p>
            <b>Ports:</b><br>
            @foreach($details['NetworkSettings']['Ports'] as $ports)
            {{ $key = array_search($ports, $details['NetworkSettings']['Ports']) }} =>
            @if(isset($ports))
            @foreach($ports as $portNumber)
            {{ $portNumber['HostIp']}}:{{ $portNumber['HostPort']}}
            @endforeach
            @endif
            @endforeach
        </p>
        <p><b>SandboxKey: </b>{{ $details['NetworkSettings']['SandboxKey'] }}</p>
        <p><b>SecondaryIPAddresses: </b>{{ $details['NetworkSettings']['SecondaryIPAddresses'] }}</p>
        <p><b>SecondaryIPv6Addresses: </b>{{ $details['NetworkSettings']['SecondaryIPv6Addresses'] }}</p>
        <p><b>EndpointID: </b>{{ $details['NetworkSettings']['EndpointID'] }}</p>
        <p><b>Gateway: </b>{{ $details['NetworkSettings']['Gateway'] }}</p>
        <p><b>GlobalIPv6Address: </b>{{ $details['NetworkSettings']['GlobalIPv6Address'] }}</p>
        <p><b>GlobalIPv6PrefixLen: </b>{{ $details['NetworkSettings']['GlobalIPv6PrefixLen'] }}</p>
        <p><b>IPAddress: </b>{{ $details['NetworkSettings']['IPAddress'] }}</p>
        <p><b>IPPrefixLen: </b>{{ $details['NetworkSettings']['IPPrefixLen'] }}</p>
        <p><b>IPv6Gateway: </b>{{ $details['NetworkSettings']['IPv6Gateway'] }}</p>
        <p><b>MacAddress: </b>{{ $details['NetworkSettings']['MacAddress'] }}</p>
    </div>
</div>