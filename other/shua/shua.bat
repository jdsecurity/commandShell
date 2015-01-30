for /l %%i in (1,1,50) do (
    rem loop20times
    ping 127.1 -n 3 >nul
    rem sleep3 

    @echo off
    rem close

    for /f %%i in (url.txt) do (
        @start /min iexplore.exe "%%i"
    )

    rem openpage

    ping 127.1 -n 25 >nul
    rem sleep15

    taskkill /im iexplore.exe /f
    rem closeIE
    rem stop
)
