export interface IWeatherData {
    input_city?: string;
    resolved_city?: string;
    condition?: string;
    temp?: number;
    temp_max?: number;
    temp_min?: number;
    pressure?: number;
    wind_speed?: number;
    wind_direction?: number;
    humidity?: number;
    visibility?: number;
}
