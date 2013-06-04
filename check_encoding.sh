#!/bin/bash
echo "Checking files in source/lib/"
for file in source/lib/*; do enc=$(file "$file" | cut -d' ' -f 4); [[ "${enc}" == "ASCII" ]] || file "$file" ; done
