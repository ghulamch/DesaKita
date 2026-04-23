
with open(r'd:\PROJECT WEBSITE\Desa\resources\views\admin\settings\index.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

def check_balance(text, open_char, close_char):
    stack = []
    for i, char in enumerate(text):
        if char == open_char:
            stack.append(i)
        elif char == close_char:
            if stack:
                stack.pop()
            else:
                print(f"Extra {close_char} at index {i}")
    for i in stack:
        print(f"Unclosed {open_char} at index {i}. Context: {text[i:i+50]}")

print("Checking ( )")
check_balance(content, '(', ')')
print("Checking { }")
# check_balance(content, '{', '}') # This will be very noisy due to CSS
