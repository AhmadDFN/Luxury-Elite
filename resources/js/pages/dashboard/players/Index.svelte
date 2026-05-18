<script>
    export let players = [];
</script>

<h1>Players</h1>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Nickname</th>
            <th>Real Name</th>
            <th>UID</th>
            <th>Division</th>
            <th>Role</th>
        </tr>
    </thead>

    <tbody>
        {#each players as player}
            <tr>
                <td>{player.nickname}</td>

                <td>{player.real_name}</td>

                <td>{player.uid_game}</td>

                <td>
                    {player.user?.division_memberships?.[0]?.division?.name}
                </td>

                <td>
                    {player.user?.division_memberships?.[0]?.role?.name}
                </td>
            </tr>
        {/each}
    </tbody>
</table>
