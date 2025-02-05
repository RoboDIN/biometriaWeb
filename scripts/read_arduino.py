import serial

# Configurar a porta serial
porta = 'COM10'  
baudrate = 9600  

try:

  arduino = serial.Serial(porta, baudrate, timeout=2)  
  print("Conexao estabelecida!") 

  linha = arduino.readline().decode('UTF-8', errors='ignore').strip()  

  if linha:
    print(f"Mensagem recebida: {linha}")  
  else:
    print("Nenhum dado recebido...")  

except Exception as e:
  print(f"Erro ao conectar: {e}")  