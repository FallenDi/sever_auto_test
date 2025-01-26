import React, { useEffect, useRef, useState } from "react";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { getNotifications, incrementNotificationViewCount } from "../api/Notifications";

// Функция для отображения уведомления
const showNotification = (notification) => {
  toast(
    <div>
      <h4>{notification.title}</h4>
      <p>{notification.content}</p>
    </div>,
    {
      position: "bottom-center", 
      autoClose: 5000,
      hideProgressBar: true,
      closeOnClick: true,
      pauseOnHover: true,
      draggable: true,
      style: {
        backgroundColor: "#f0f0f0",
        borderRadius: "8px",
        boxShadow: "0px 4px 6px rgba(0,0,0,0.1)",
        padding: "15px",
        width: "300px",
      },
    }
  );
};

const NotificationComponent = () => {
  const displayedNotifications = useRef(new Set()); // Отслеживаем показанные уведомления
  const [isShowing, setIsShowing] = useState(false); // Флаг показа уведомления

  useEffect(() => {
    const fetchAndShowNotifications = async () => {
      const notifications = await getNotifications();

      if (notifications.length === 0) {
        console.log("No notifications to show");
        return;
      }

      // Показ уведомлений последовательно
      const showNextNotification = async (index) => {
        if (index >= notifications.length) return;

        const notification = notifications[index];

        if (!displayedNotifications.current.has(notification.title)) {
          setIsShowing(true); // Устанавливаем флаг показа
          showNotification(notification); // Показываем уведомление
          displayedNotifications.current.add(notification.title); // Отмечаем уведомление как показанное

          // Инкрементируем счетчик просмотров на сервере
          await incrementNotificationViewCount(notification.id);

          
          setTimeout(() => {
            setIsShowing(false);
            setTimeout(() => {
              showNextNotification(index + 1);
            }, 1500);
          }, 5000); 
        }
      };

      showNextNotification(0);
    };

    fetchAndShowNotifications();
  }, []);

  return (
    <div>
      <ToastContainer />
    </div>
  );
};

export default NotificationComponent;
