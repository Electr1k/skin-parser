import SkinSearchApi from "@/api/SkinSearchApi";
import LotsApi from "@/api/LotsApi";

export const $api = {
  skinSearch: new SkinSearchApi(),
  lots: new LotsApi(),
}
