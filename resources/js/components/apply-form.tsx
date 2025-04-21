import { useForm } from "@inertiajs/react";

interface ApplyFormData {
  name: string;
  email: string;
  dni: string;
  phone: string;
  [key: string]:any;
}

export default function ApplyForm() {
  const { data, setData, post, processing, errors, reset } = useForm<ApplyFormData>({
    name: '',
    email: '',
    dni: '',
    phone: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post('/apy/apply', {
      onSuccess: () => {
        alert('✅ Aplicación enviada correctamente');
        reset();
      },
    });
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <div>
        <label className="block">Nombre</label>
        <input 
        type="text"
        value={data.name}
        onChange={(e) => setData('name', e.target.value)}
        className="w-full border px-2 py-1" />
        {errors.email && <p className="text-red-500 text-sm">{errors.email}</p>}
      </div>
      <div>
        <label className="block">Email</label>
        <input 
        type="text"
        value={data.email}
        onChange={(e) => setData('email', e.target.value)}
        className="w-full border px-2 py-1"
        />
        {errors.email && <p className="text-red-500 text-sm">{errors.email}</p>}
      </div>
      <div>
        <label className="block">DNI</label>
        <input 
        type="text"
        value={data.dni}
        onChange={(e) => setData('dni', e.target.value)}
        className="w-full border px-2 py-1"
        />
        {errors.dni && <p className="text-red-500 text-sm">{errors.dni}</p>}
      </div>
      <div>
        <label className="block">Telefono</label>
        <input 
        type="text"
        value={data.phone}
        onChange={(e) => setData('phone', e.target.value)}
        className="w-full border px-2 py-1"
        />
        {errors.phone && <p className="text-red-500 text-sm">{errors.phone}</p>}
      </div>
      <button
      type="submit"
      disabled={processing}
      className="bg-blue-600 text-white px-4 py-2 rounded"
      >
        Enviar Solicitud
      </button>
    </form>
  )
}