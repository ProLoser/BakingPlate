find ./ -name "*.php" -print0 | xargs -0 grep -H "#!#"
find ./ -name "*.ctp" -print0 | xargs -0 grep -H "#!#"
