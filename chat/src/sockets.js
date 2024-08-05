import { Mensaje } from "./models/Mensaje.js";
import notifier from 'node-notifier';

export default (io) => {
    io.on("connection", async (socket) => {
        const emitMensajes = async () => {
            const mensajes = await Mensaje.find();
            io.emit("server:mensajes", mensajes);
        }
        emitMensajes();

        socket.on("client:nuevoMensaje", async (data) => {
            const newMensaje = new Mensaje(data);
            const savedMensaje = await newMensaje.save();
            io.emit("server:nuevoMensaje", savedMensaje); 

            notifier.notify({
                title: 'Nuevo mensaje recibido',
                message: `De: ${savedMensaje.sender}`,
                icon: './chat/inicio.png', 
                sound: true, 
                timeout: 5000, 
                wait: true 
            });
        });
    });
};
