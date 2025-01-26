export const getNotifications = async () => {
    try {
      const response = await fetch("http://localhost:8080/admin/notification-api/list", {
        headers: {
          Accept: "application/json",
        },
        credentials: "include",
      });
  
      if (!response.ok) {
        console.error("HTTP Error:", response.status);
        throw new Error("Failed to fetch notifications");
      }
  
      const data = await response.json();
        return data;
    } catch (error) {
      console.error("Error fetching notifications:", error);
        return [];
    }
};

export const incrementNotificationViewCount = async (notificationId) => {
    try {
      const response = await fetch(
        `http://localhost:8080/admin/notification-api/increment-view/${notificationId}`,
        {
          method: "POST",
          headers: {
            Accept: "application/json",
          },
          credentials: "include",
        }
      );
  
      if (!response.ok) {
        console.error("Failed to increment view count for notification ID:", notificationId);
        throw new Error("Failed to update view count");
      }
  
      console.log(`View count incremented for notification ID: ${notificationId}`);
    } catch (error) {
      console.error("Error incrementing view count:", error);
    }
  };
  