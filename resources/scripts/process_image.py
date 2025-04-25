import sys
import base64
import requests
from PIL import Image
from io import BytesIO

def process_image(image_path):
    # Abrir la imagen
    with open(image_path, "rb") as image_file:
        image_data = image_file.read()

    # Codificar la imagen a base64
    image_base64 = base64.b64encode(image_data).decode('utf-8')

    # Aquí podrías llamar a un modelo para obtener una descripción o realizar cualquier otra operación
    model_response = send_to_model(image_base64)  # Llamamos al modelo de procesamiento

    # Extraer la descripción del modelo (o cualquier otra información que devuelva el modelo)
    description = model_response.get("description", "Descripción no disponible")

    # Regresar la base64 de la imagen y la descripción
    return {
        'image_base64': image_base64,
        'description': description
    }

def send_to_model(image_base64):
    # URL de la API que procesará la imagen (ajustar según el endpoint correcto)
    api_url = 'http://localhost:11434/v1/run/llava'  # Asegúrate de que la URL sea correcta

    # Cuerpo de la solicitud (payload)
    payload = {
        'image': image_base64
    }

    # Realizar la solicitud POST al servidor
    response = requests.post(api_url, json=payload)

    if response.status_code == 200:
        return response.json()  # Asumimos que la respuesta es un JSON con una descripción y otros datos
    else:
        # Manejo de errores si la solicitud falla
        raise Exception(f"Error al procesar la imagen: {response.status_code}, {response.text}")

def main():
    # Verificar si la imagen fue proporcionada como argumento
    if len(sys.argv) < 2:
        print("Se debe proporcionar la ruta de la imagen como argumento.")
        sys.exit(1)

    # Ruta de la imagen proporcionada
    image_path = sys.argv[1]
    
    # Procesar la imagen
    print("Procesando imagen...")
    result = process_image(image_path)
    
    # Mostrar la respuesta del modelo (incluyendo la base64 de la imagen y la descripción)
    print("Respuesta del modelo:")
    print(f"Descripción: {result['description']}")
    print(f"Imagen base64: {result['image_base64']}")

if __name__ == "__main__":
    main()
