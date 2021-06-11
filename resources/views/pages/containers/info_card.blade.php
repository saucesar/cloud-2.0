<div class="card shadow bg-secondary">
    <div class="card-header">
        <h2>Info</h2>
    </div>
    <div class="card-body">
        <ul>
            <li>To enable access via SSH open the <b>terminal</b> in the container and run <b>"service ssh start"</b></li>
            <li>
                After enabling SSH, access with the command
                <b>ssh root{{ '@' }}{{ $_SERVER['SERVER_NAME'] }}
                @if(isset($details['NetworkSettings']['Ports']))
                    @foreach($details['NetworkSettings']['Ports'] as $key => $portNumber)
                        @if($key == "22/tcp")
                            -p {{ $portNumber[0]['HostPort'] }}
                        @endif
                    @endforeach
                @endif
                </b>
            </li>
            <li>The default root password for your container is <b>docker</b></li>
        </ul>
    </div>
</div>
