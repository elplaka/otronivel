git rev-list --objects --all | git cat-file --batch-check='%(objectname) %(objecttype) %(objectsize) %(rest)' | Select-String "blob" | ForEach-Object {
    $parts = $_ -split '\s+'
    if ($parts.Length -ge 3) {
        $size = [int]$parts[2]
        $file = $parts[3]
        if ($file.Length -gt 0) {
            New-Object PSObject -Property @{ Size = $size; File = $file }
        }
    }
} | Sort-Object Size -Descending | Select-Object -First 10